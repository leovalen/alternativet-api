<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:setpasswords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the phone number as password for users where password is currently null';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            if ( is_null($user->password) && ! is_null($user->phone) )
            {
                $user->password = password_hash($user->phone, PASSWORD_DEFAULT);
                $user->save();
            }
        }
    }
}
