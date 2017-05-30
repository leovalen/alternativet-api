<?php

namespace App\Jobs;

use App\Membership;
use App\Repositories\UserRepository;
use App\Typeform;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class HandleTypeform
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $typeform;
    protected $users;

    /*
     * The Typeform instance.
     *
     * @var Typeform $typeform
     */

    /**
     * Create a new job instance.
     */
    public function __construct(Typeform $typeform)
    {
        $this->typeform = $typeform;
        $this->users = new UserRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = json_decode($this->typeform->data);

        if ($data->form_response->form_id == "R0wZBU")
        {
            $this->handleSignup($data);
        }
    }

    /**
     * Handle a member sign-up received through Typeform
     *
     * @param $data
     */
    protected function handleSignup($data)
    {
        $user = $this->users->getUserByUuid($data->form_response->hidden->token);

        foreach ( $data->form_response->answers as $answer)
        {
            switch ($answer->field->id) {

                case "ksBb":
                    // "Hva er postnummeret ditt?"
                    $user->postal_code = $answer->text;
                    break;

                case "ONCX":
                    // "Når ble du født?"
                    $user->birth_date = $answer->date;
                    break;

                case "L1TL":
                    // "Hvordan ble du kjent med Alternativet?"
                    break;

                case "52133648":
                    // "Vil du bli medlem i Alternativet?"
                    if ( $answer->boolean === true )
                    {
                        $this->users->activateMembership($user);
                    }
                    break;

                case "oOau":
                    // "Hvor mye vil du betale i kontingent?"
                    break;

                case "H5yk":
                    $amount = $answer->payment->amount;
                    break;
            }
        }

        $user->save();
    }
}
