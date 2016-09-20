<?php

namespace Api\Controllers;

use App\KickboxResult;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kickbox\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
{
    public function me(Request $request)
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function validateToken() 
    {
        // Our routes file should have already authenticated this token, so we just return success here
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function register(Request $request)
    {
        // Check if the user exists but does not have a password set.
        $user = User::where('email', $request->get('email'))->whereNull('password');

        if ($user)
        {
            // Send email with link to login and set password

        }

        // Sanitize input
        $input = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => str_replace( " ", "", $request->get('phone')),
            'postal_code' => $request->get('postal_code') ? $request->get('postal_code') : null,
            'birth_date' => $request->get('birth_date') ? Carbon::createFromFormat( 'd.m.Y', $request->get('birth_date')) : null,
            'password' => $request->get('password') ? bcrypt($request->get('password')) : null,
        ];

        // Set the validation rules
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|kickbox|email|max:255|unique:users',
            'phone' => 'required|max:15|unique:users',
            'postal_code' => 'digits:4',
            'birth_date' => 'date_format:d.m.Y',
            'password' => 'confirmed|min:8',
        ];

        Validator::extend('kickbox', function($attribute, $value, $parameters, $validator) {

            $client = new Client('f19f5e96ef43cfb54a6704ccec1059fd00c2099527ba97b0a3b2c4f476031048');
            $kickbox = $client->kickbox();
            $response = $kickbox->verify($value);
            $result = KickboxResult::create($response->body);

            if ( $result->result == 'undeliverable' )
            {
                return false;
            }
            return true;
        });

        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {



        });

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }

        // Create the new user
        $user = User::create($input);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }
}