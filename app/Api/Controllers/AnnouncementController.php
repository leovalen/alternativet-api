<?php

namespace Api\Controllers;

use Api\Transformers\AnnouncementTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Announcement;

use App\Http\Requests;

class AnnouncementController extends BaseController
{
    public function index()
    {
        return $this->collection( Announcement::all(), new AnnouncementTransformer);
    }

    /**
     * Show the latest announcement
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        return $this->item(
            Announcement::where('publish_at', '>', Carbon::now())
                ->where('unpublish_at', '<', Carbon::now())
                ->orWhere('unpublish_at', null)
                ->orderBy('publish_at', 'desc')
                ->limit(1)
                ->get()
                ->first(),
            new AnnouncementTransformer
        );

    }
}
