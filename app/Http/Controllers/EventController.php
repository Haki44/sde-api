<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Boat;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *      path="/event",
     *      operationId="IndexEvent",
     *      tags={"Events"},

     *      summary="Get all Events",
     *      description="Get all Events",
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
        return EventResource::collection(Event::get());
    }

    /**
     * @OA\Post(
     *      path="/event",
     *      operationId="storeEvent",
     *      tags={"Events"},

     *      summary="Store Event",
     *      description="Store Event",
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
            'title' => 'required|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'boat_id' => 'required|numeric',
        ]);

        Event::create($data);
    }

    /**
     * @OA\Get(
     *      path="/event/{id}",
     *      operationId="ShowEvent",
     *      tags={"Events"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of Event",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Get one Event",
     *      description="Get one Event",
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
        return new EventResource(Event::findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/event/{id}",
     *      operationId="UpdateEvent",
     *      tags={"Events"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of Event",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one Event",
     *      description="Update one Event",
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
            'title' => 'required|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'boat_id' => 'required|numeric',
        ]);

        Event::where('id', $id)->update($data);
    }

    /**
     * @OA\Delete(
     *      path="/event/{id}",
     *      operationId="DeleteEvent",
     *      tags={"Events"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of Event",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Delete one Event",
     *      description="Delete one Event",
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
        return new EventResource(Event::findOrFail($id)->delete());
    }
}
