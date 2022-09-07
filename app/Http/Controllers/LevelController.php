<?php

namespace App\Http\Controllers;

use App\Http\Resources\LevelResource;
use App\Models\Level;

class LevelController extends Controller
{
    /**
     * @OA\Get(
     *      path="/level",
     *      operationId="IndexLevel",
     *      tags={"Levels"},

     *      summary="Get all Level",
     *      description="Get all Level",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function index()
    {
        return LevelResource::collection(Level::get());
    }

}
