<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdventureResource;
use App\Models\Adventure;
use App\Models\AdventureBooking;
use App\Models\Level;
use App\Models\Picture;
use App\Models\User;
use App\Notifications\AdventureBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdventureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        /**
     * @OA\Get(
     *      path="/adventure",
     *      operationId="indexAdventure",
     *      tags={"Adventures"},

     *      summary="Get List Of adventures",
     *      description="Returns all adventures",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function index()
    {
        return AdventureResource::collection(Adventure::with(['pictures'])->paginate(30));
    }

    /**
     * @OA\Post(
     *      path="/adventure",
     *      operationId="storeAdventure",
     *      tags={"Adventures"},

     *      summary="Store adventure",
     *      description="Store adventure",
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
            'level_id' => 'required',
            'family' => 'required',
            'price' => 'required|numeric',
            'places' => 'required|numeric',
            'available_places' => 'required|numeric',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
            'picture' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
        ],
        [
            'name.required' => 'You must indicate the name of the adventure',
            'name.max' => 'The name of the adventure is too long !',
            'description_fr.required' => 'You must give a french description to your adventure',
            'description_en.required' => 'You must give an english description to your adventure',
        ]
        );

        $adventure = Adventure::create($data);

        if($request->file()) {
            $filename = $adventure->name . '-' . time() . '-' . $request->picture->getClientOriginalName();
            $file = $adventure->pictures()->create([
                'adventure_id' => $adventure->id,
                'picture' => $filename,
                'is_first' => 1,
            ]);
            $request->file('picture')->storeAs('adventure/' . $adventure->id, $file->id . '-' . $filename, 'public');
        }

        // if(isset($data['picture'])){

        //     foreach($data['picture'] as $key => $uploadedFile) {
        //         $filename = $adventure->name . '-' . time() . '-' . $uploadedFile->getClientOriginalName();

        //         if($key == 0){
        //             $file = $adventure->pictures()->create([
        //                 'adventure_id' => $adventure->id,
        //                 'picture' => $filename,
        //                 'is_first' => 1,
        //             ]);
        //         } else {
        //             $file = $adventure->pictures()->create([
        //                 'adventure_id' => $adventure->id,
        //                 'picture' => $filename,
        //                 'is_first' => 0,
        //             ]);
        //         }

        //         $uploadedFile->storeAs('adventure/' . $adventure->id, $file->id . '-' . $filename, 'public');
        //     }
        // }

        // return redirect()->route('adventure.index', app()->getLocale());
    }

    /**
     * @OA\Get(
     *      path="/adventure/{id}",
     *      operationId="ShowAdventure",
     *      tags={"Adventures"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of adventure",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Show one adventure",
     *      description="Show one adventure",
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
        return new AdventureResource(Adventure::with(['pictures', 'level'])->findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/adventure/{id}",
     *      operationId="updateAdventure",
     *      tags={"Adventures"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of adventure",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one adventure",
     *      description="Update one adventure",
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
            'level_id' => 'required',
            'family' => 'required',
            'price' => 'required|numeric',
            'places' => 'required|numeric',
            'available_places' => 'required|numeric',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
        ],
        [
            'name.required' => 'You must indicate the name of the adventure',
            'name.max' => 'The name of the adventure is too long !',
            'description_fr.required' => 'You must give a french description to your adventure',
            'description_en.required' => 'You must give an english description to your adventure',
        ]
        );

        Adventure::where('id', $id)->update($data);

        // $data_files = $request->validate([
        //     'filename_delete' => 'nullable|array',
        // ]);

        // if(!empty($data_files['filename_delete'])){

        //     Picture::whereIn('id', $data_files['filename_delete'])->delete();
        // }

        // $adventure = Adventure::where('id', $id)->find($id);

        // $data_files = $request->validate([
        //     'picture' => 'array',
        // ]);


        // if(isset($data_files['picture'])){

        //     foreach($data_files['picture'] as $uploadedFile) {
        //         $filename = $adventure->name . '-' . time() . '-' . $uploadedFile->getClientOriginalName();

        //         $file = $adventure->pictures()->create([
        //             'adventure_id' => $adventure->id,
        //             'picture' => $filename,
        //             'is_first' => 0,
        //         ]);

        //         $uploadedFile->storeAs('adventure/' . $adventure->id, $file->id . '-' . $filename, 'public');
        //     }
        // }

        // return redirect()->route('adventure.index', app()->getLocale());
    }

    /**
     * @OA\Delete(
     *      path="/adventure/{id}",
     *      operationId="deleteAdventure",
     *      tags={"Adventures"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of adventure",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Delete one adventure",
     *      description="Delete one adventure",
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
        return new AdventureResource(Adventure::findOrFail($id)->delete());
    }

    /**
     * @OA\Post(
     *      path="/adventure-booking",
     *      operationId="storeAdventureBooking",
     *      tags={"Adventure Booking"},

     *      summary="Store one Adventure booking",
     *      description="Update one Adventure booking",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function register_booking(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'firstname' => 'required|max:255',
            'nationality' => 'required|max:255',
            'email' => 'required|email',
            'tel' => 'required',
            'places_needed' => 'required|numeric',
            'description' => 'required|max:10000',
            'user_id' => 'required',
            'adventure_id' => 'required',
        ]);

        // Enregistrement de la demande de reservation d'aventure
        AdventureBooking::create($data);

        $adventure = Adventure::find($data['adventure_id']);

        $admins = User::where('admin', '1')->get();

        // Envoie de l'email à tous les admins
        foreach ($admins as $admin) {
            $admin->notify(new AdventureBookingNotification($data, $adventure));
        }
    }
}
