<?php

namespace App\Http\Controllers;

use App\Http\Resources\PictureResource;
use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function index()
    {
        return PictureResource::collection(Picture::get());
    }
}
