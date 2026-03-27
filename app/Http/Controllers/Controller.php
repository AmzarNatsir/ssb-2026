<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Route;

class Controller extends BaseController
{
    const ROUTE_BASE_NAME = '';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function routeMethod($method = 'index')
    {
        return get_called_class()::ROUTE_BASE_NAME . $method;
    }

    public function generateResponse(bool $status, string $route)
    {
        if ($status) {
            return redirect()->route($this->routeMethod($route));
        }
    }
}
