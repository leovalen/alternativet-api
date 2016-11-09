<?php

namespace Api\Controllers;

use App\Jobs\HandleTypeform;
use App\Typeform;
use Illuminate\Http\Request;
use App\Http\Requests;

class TypeformController extends BaseController
{
    /**
     * Store typeform input data and dispatch a handler job
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeform = new Typeform();
        $typeform->data = $request->input();
        $typeform->save();

        $data = json_decode($typeform->data);

        if ($data->event_type != 'form_response')
        {
            return;
        }

        $this->dispatch(new HandleTypeform($typeform));
    }
}
