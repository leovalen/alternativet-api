<?php

namespace App\Jobs;

use App\Membership;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = json_decode($this->typeform->data);

        if ($data->form_response->form_id == "u5OmqD")
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
        $user = new User;
        $membership = null;

        foreach ( $data->form_response->answers as $answer)
        {
            switch ($answer->field->id) {

                case 34684524:
                    // "Hva heter du?"
                    $user->name = $answer->text;
                    break;

                case 34684651:
                    // "Hva er mobilnummeret ditt?"
                    $user->phone = $answer->text;
                    break;

                case 34684952:
                    // "Hva er e-postadressen din?"
                    $user->email = $answer->email;
                    break;

                case 34688420:
                    // "Når ble du født?"
                    $user->birth_date = $answer->date;
                    break;

                case 35451671:
                    // "Hva er postnummeret ditt?"
                    $user->postal_code = $answer->text;
                    break;

                case 34686331:
                    // "Hvordan ble du kjent med Alternativet?"
                    break;

                case 34688877:
                    // "Vil du være med på dugnad?"
                    break;

                case 34685729:
                    // "Ønsker du medlemskap i Alternativet?"
                    $membership = new Membership;
                    $membership->valid_from = Carbon::now();
                    $membership->valid_to = Carbon::now()->addYear();
                    break;

                case 34685206:
                    // "Vil du bidra med penger til Alternativets aktiviteter?"
                    break;

                case 34688977:
                    //
                    break;
            }
        }

        // Check if there's a already a registered user with the same email address and/or phone number
        if ( User::where('email', '=', $user->email)->count() > 0 )
        {
            // User already exists, so we'll send an email instead of overwriting the existing record
            // @todo
            return;
        }

        $user->save();

        if ( isset($membership) )
        {
            $membership->user()->associate($user);
            $membership->save();
        }
    }
}
