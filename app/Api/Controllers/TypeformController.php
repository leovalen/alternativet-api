<?php

namespace Api\Controllers;

use App\Jobs\HandleTypeform;
use App\Typeform;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

class TypeformController extends BaseController
{
    use DispatchesJobs;

    /**
     * Store typeform input data and dispatch a handler job
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeform = new Typeform();
        $typeform->data = json_encode($request->input());
        $typeform->save();


        if ($request->input('event_type') != 'form_response')
        {
            return;
        }

        $this->dispatch(new HandleTypeform($typeform));
    }
}
