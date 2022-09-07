<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkipperResource;
use App\Models\Skipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SkipperController extends Controller
{
    /**
     * @OA\Get(
     *      path="/skipper",
     *      operationId="IndexSkipper",
     *      tags={"Skippers"},

     *      summary="Get all skipper",
     *      description="Get all skipper",
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
        return SkipperResource::collection(Skipper::get());
    }

    /**
     * @OA\Post(
     *      path="/skipper",
     *      operationId="StoreSkipper",
     *      tags={"Skippers"},

     *      summary="Store skipper",
     *      description="Store skipper",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'firstname' => 'required|max:255',
            'picture'=> 'required',
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
            'languages' => 'required|max:10000',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
        ]
        );

        if(isset($data['picture'])){
            // dd($request->picture->extension());
            $filename = $data['name'] . '-' . time() . '.' . $request->picture->extension();

            $request->file('picture')->storeAs('skipper/' . $data['name'] . '-' . $data['firstname'], $filename, 'public');

            $data['picture'] = $filename;
        };

        Skipper::create($data);

        return redirect()->route('skipper.index', app()->getLocale());
    }

    /**
     * @OA\Get(
     *      path="/skipper/{id}",
     *      operationId="ShowSkipper",
     *      tags={"Skippers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of skipper",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Show one skipper",
     *      description="Show one skipper",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function show($id)
    {
        return new SkipperResource(Skipper::findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/skipper/{id}",
     *      operationId="UpdateSkipper",
     *      tags={"Skippers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of skipper",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one skipper",
     *      description="Update one skipper",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'firstname' => 'required|max:255',
            'picture'=> 'nullable',
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
            'languages' => 'required|max:10000',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
        ]
        );
        
        if(isset($data['picture'])){
            // dd($request->picture->extension());
            $filename = $data['name'] . '-' . time() . '.' . $request->picture->extension();

            $request->file('picture')->storeAs('skipper/' . $data['name'] . '-' . $data['firstname'], $filename, 'public');

            $data['picture'] = $filename;
        };

        Skipper::where('id', $id)->update($data);

        return redirect()->route('skipper.index', app()->getLocale());
    }

    /**
     * @OA\Delete(
     *      path="/skipper/{id}",
     *      operationId="DeleteSkipper",
     *      tags={"Skippers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of skipper",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Delete one skipper",
     *      description="Delete one skipper",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function destroy($id)
    {
        return new SkipperResource(Skipper::findOrFail($id)->delete());
    }
}
