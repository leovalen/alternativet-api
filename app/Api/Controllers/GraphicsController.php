<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GraphicsController extends Controller
{
    /**
     * Norwegian map with municipalities where Alternativet is represented highlighted
     */
    public function membersMapNorway()
    {
        return view('graphics/members-map-norway');
    }
}
