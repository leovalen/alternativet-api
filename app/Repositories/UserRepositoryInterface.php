<?php

namespace App\Repositories;

use App\User;

interface UserRepositoryInterface
{
    public function getUserById($id);
    public function getUserByUuid($uuid);
    public function getAllUsers();

    public static function activateMembership(User $user);
    public static function sendResetPasswordTokenEmail(User $user);
    public static function create($data = null);
}
