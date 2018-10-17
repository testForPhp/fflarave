<?php

namespace App\Http\Controllers;

use App\Repositories\SystemRepository;
use App\Tools\ApiMessage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiMessage;

    protected function imgServer()
    {
        $system = (new SystemRepository())->checkCache();

        if(empty($system)){
            return false;
        }
        return $system->imgServer;
    }
}
