<?php

namespace Api\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class StatisticsController extends Controller
{
    public function users()
    {
        $result = DB::select( DB::raw("
          select postal_areas.municipality_code, count(*) as count
          from users
          left join postal_areas
          on (users.postal_code = postal_areas.postal_code)
          group by municipality_code"));

        
    }
}
