<?php

namespace App\Jobs\Workplace;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DeleteAccount implements ShouldQueue
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

        if ( ! $user->workplace )
        {
            Log::info("User " . $user->id . " doesn't have a workplace account, so the account can't be deleted.");
            return;
        }

        $request = [
            'schemas' => [
                'urn:scim:schemas:core:1.0',
            ],
            'active' => false,
            'userName' => $user->email,
            'name' => [
                'formatted' => $user->name
            ],
        ];

        $client = new Client(['base_uri' => config('services.workplace.scim_url')]);
        $response = $client->request('PUT', 'Users/' . $user->workplace->workplace_id, [
            'headers' => ['Authorization' => "Bearer " . config('services.workplace.api_token')],
            'body' => json_encode($request, JSON_FORCE_OBJECT),
            'exceptions' => false,
        ]);

        if ( $response->getStatusCode() !== 200 )
        {
            // It didn't work
            return $response->getBody();
        }

        $user->workplace->delete();
    }
}
