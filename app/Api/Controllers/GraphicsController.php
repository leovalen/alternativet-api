<?php

namespace Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class GraphicsController extends BaseController
{
    /**
     * Norwegian map with municipalities where Alternativet is represented highlighted
     */
    public function membersMapNorway()
    {
        $svg = simplexml_load_file(base_path() . '/resources/svg/Norway_municipalities_2012_blank.svg');

        // dd($svg);

        

        foreach ( $svg->g as $county )
        {
            foreach ($county->path as $path)
            {
                $path['style'] = 'fill:#555;fill-opacity:1;stroke:none';
                //print_r($path['id']);
            }
        }
        return response($svg->asXML())
            ->header('Content-Type', 'image/svg+xml');
    }
}
