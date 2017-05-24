<?php

namespace App\Repositories;

use App\Jobs\Workplace\ProvisionAccount;
use App\LoginToken;
use App\Mail\ResetPassword;
use App\Membership;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getUserByUuid($uuid)
    {
        return User::whereUuid($uuid)->get()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllUsers()
    {
        return User::all();
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->user, $method], $args);
    }

    /**
     * @param User $user
     * @return LoginToken
     */
    public static function getLoginToken(User $user)
    {
        $token = new LoginToken;
        $token->user_id = $user->id;
        $token->token = str_random(63);
        $token->expires_at = Carbon::now()->addHours(72);
        $token->save();

        return $token;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function activateMembership(User $user)
    {
        if ( ! $user->membership->isEmpty() )
        {
            return false;
        }

        $membership = new Membership();
        $membership->valid_from = Carbon::now();
        $membership->valid_to = Carbon::now()->addYear();
        $user->memberships()->save($membership);

        // Provision Workplace account
        dispatch(new ProvisionAccount($user));
    }

    /**
     * @param User $user
     */
    public static function sendResetPasswordTokenEmail(User $user)
    {
        $token = self::getLoginToken($user);
        Mail::to($user->email)->send(new ResetPassword($user, $token));
    }

    /**
     * @param null $data
     * @return static
     */
    public static function create($data = null)
    {
        $user = User::create($data);

        // Set the user's UUID
        $user->uuid = Uuid::uuid4();
        $user->save();

        // Send password reset e-mail
        self::sendResetPasswordTokenEmail($user);

        return $user;
    }
}
