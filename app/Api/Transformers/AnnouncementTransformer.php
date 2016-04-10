<?php

namespace Api\Transformers;

use App\Announcement;
use League\Fractal\TransformerAbstract;

class AnnouncementTransformer extends TransformerAbstract
{
    public function transform(Announcement $announcement)
    {
        return [
            'id' 	        => (int) $announcement->id,
            'message'       => (string) $announcement->message,
            'url'           => (string) $announcement->url,
            'publish_at'    => $announcement->publish_at,
            'unpublish_at'  => $announcement->unpublish_at
        ];
    }
}