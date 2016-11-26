<?php

namespace App\Jobs\Workplace;

use App\User;
use App\WorkplaceAccount;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProvisionAccount implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The User instance
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        $request = [
            'schemas' => [
                'urn:scim:schemas:core:1.0',
                'urn:scim:schemas:extension:enterprise:1.0',
            ],
            'userName' => $user->email,
            'name' => [
                'formatted' => $user->name
            ],
            'title' => 'Medlem',
            'active' => true,
            'emails' => [
                ['value' => $user->email, 'type' => 'work', 'primary' => true]
            ],
            'urn:scim:schemas:extension:enterprise:1.0' => [
                'department' => 'Alternativet'
            ]
        ];

        $client = new Client(['base_uri' => config('services.workplace.scim_url')]);
        $response = $client->request('POST', 'Users', [
            'headers' => ['Authorization' => "Bearer " . config('services.workplace.api_token')],
            'body' => json_encode($request, JSON_FORCE_OBJECT),
            'exceptions' => false,
        ]);

        if ( $response->getStatusCode() !== 201 )
        {
            // It didn't work
            return $response->getBody();
        }

        $body = json_decode($response->getBody()->getContents());

        $account = new WorkplaceAccount();
        $account->user()->associate($user);
        $account->workplace_id = $body->id;
        $account->active = $body->active;
        $account->save();
    }
}
