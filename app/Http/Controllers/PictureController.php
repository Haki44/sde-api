<?php

namespace App\Http\Controllers;

use App\Http\Resources\PictureResource;
use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * @OA\Get(
     *      path="/picture",
     *      operationId="IndexPicture",
     *      tags={"Pictures"},

     *      summary="Get all Picture",
     *      description="Get all Picture",
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
        return PictureResource::collection(Picture::get());
    }
}
