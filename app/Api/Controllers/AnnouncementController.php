<?php

namespace Api\Controllers;

use Api\Transformers\AnnouncementTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Announcement;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

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
        $announcement = Announcement::orderBy('publish_at', 'desc')
            ->limit(1)
            ->get()
            ->first();

        if ($announcement) {
            return $this->item($announcement, new AnnouncementTransformer);
        }
        else
        {
            return [];
        }
    }
}
