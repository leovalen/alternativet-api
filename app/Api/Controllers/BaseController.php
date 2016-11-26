<?php

namespace Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers;
    use DispatchesJobs;
}