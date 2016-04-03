<?php

namespace Api\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class StatisticsController extends BaseController
{
    public function users()
    {
        // Determine the number of municipalities in which there are members
        $results = DB::select( DB::raw("
          select postal_areas.municipality_code, count(*) as count
          from postal_areas
          right join users
          on (postal_areas.postal_code = users.postal_code)
          group by municipality_code"));

        $municipalities = count($results);

        // Don't count municipality for users with unknown municipality
        if ( $results[0]->municipality_code == null && count($results >= 1) )
        {
            --$municipalities;
        }

        // Sum the number of counties and the total number of users
        $users = 0;
        $counties = [];

        foreach ( $results as $result )
        {
            $users += $result->count;
            if ( $result->municipality_code != null )
            {
                $counties[] = substr($result->municipality_code, 0, 2);
            }
        }
        $counties = count(array_unique($counties));

        return [
            'users' => $users,
            'municipalities' => $municipalities,
            'counties' => $counties
        ];
    }
}
