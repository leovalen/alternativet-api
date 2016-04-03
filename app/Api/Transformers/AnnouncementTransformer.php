<?php

namespace Api\Transformers;

use App\Announcement;
use App\Dog;
use League\Fractal\TransformerAbstract;

class AnnouncementTransformer extends TransformerAbstract
{
    public function transform(Announcement $announcement)
    {
        return [
            'id' 	        => (int) $announcement->id,
            'content'       => $announcement->content,
            'publish_at'    => $announcement->publish_at,
            'unpublish_at'  => $announcement->unpublish_at
        ];
    }
}