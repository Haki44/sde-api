<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="Api SDE for mobile sde", 
 *      version="0.1",
 *      description="Implementation of Swagger with in Laravel",
 * )
 * @OA\Server(
 *      url="https://haki44.eu/api",
 *      description="API SDE"
 * )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
