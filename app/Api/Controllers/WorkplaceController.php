<?php

namespace Api\Controllers;

use App\WorkplaceAccount;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * @Resource("Dogs", uri="/dogs")
 */
class WorkplaceController extends BaseController
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Current Workplace user status
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function status()
    {
        $user = Auth::user();

        if ( empty($user->workplace) )
        {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return $user->workplace;
    }

    /**
     * Provision the current user for Workplace
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function provision()
    {
        $user = Auth::user();

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

    /**
     * Deactivate the user's workplace account
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivate()
    {
        $user = Auth::user();

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

        $user->workplace->active = false;
        $user->workplace->save();
    }

    /**
     * Delete the user's workplace account
     *
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $user = Auth::user();

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
