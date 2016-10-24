<?php

namespace Api\Controllers;

use Api\Transformers\AnnouncementTransformer;
use App\Typeform;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Announcement;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class TypeformController extends BaseController
{
    /**
     * Show the latest announcement
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeform = new Typeform();
        $typeform->data = $request->input();
        $typeform->save();
    }
}
