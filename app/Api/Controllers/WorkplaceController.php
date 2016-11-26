<?php

namespace Api\Controllers;

use App\Jobs\Workplace\DeactivateAccount;
use App\Jobs\Workplace\DeleteAccount;
use App\Jobs\Workplace\ProvisionAccount;
use Auth;


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
        $this->dispatch(new ProvisionAccount($user));

        return $this->response->accepted();
    }

    /**
     * Deactivate the user's workplace account
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivate()
    {
        $user = Auth::user();
        $this->dispatch(new DeactivateAccount($user));

        return $this->response->accepted();
    }

    /**
     * Delete the user's workplace account
     *
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $user = Auth::user();
        $this->dispatch(new DeleteAccount($user));

        return $this->response->accepted();
    }
}
