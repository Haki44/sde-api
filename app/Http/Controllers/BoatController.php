<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoatResource;
use App\Models\Boat;
use App\Models\BoatBooking;
use App\Models\BoatRentalPrice;
use App\Models\Event;
use App\Models\Period;
use App\Models\Picture;
use App\Models\User;
use App\Notifications\BoatBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use OpenApi\Annotation as OA;

class BoatController extends Controller
{

    /**
     * @OA\Get(
     *      path="/boat",
     *      operationId="indexBoat",
     *      tags={"Boats"},

     *      summary="Get List Of boats",
     *      description="Returns all boats",
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
        return BoatResource::collection(Boat::with(['pictures', 'boatRentalPrices', 'boatBookings'])->paginate(30));
    }

    /**
     * @OA\Post(
     *      path="/boat",
     *      operationId="storeBoat",
     *      tags={"Boats"},

     *      summary="Store boat",
     *      description="Store boat",
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
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
            // 'picture' => 'array',
            'picture' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
            'type_fr' => 'required|max:255',
            'type_en' => 'required|max:255',
            'displacements' => 'required|numeric',
            'surface' => 'required|numeric',
            'engine_power' => 'required|numeric',
            'hull_fr' => 'required|max:255',
            'hull_en' => 'required|max:255',
            'deck_fr' => 'required|max:255',
            'deck_en' => 'required|max:255',
            'mast_fr' => 'required|max:255',
            'mast_en' => 'required|max:255',
            'architect' => 'required|max:255',
            'diverse_fr' => 'required|max:255',
            'diverse_en' => 'required|max:255',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
            'description_fr.required' => 'You must give a french description to your boat',
            'description_en.required' => 'You must give an english description to your boat',
        ]
        );

        $boat = Boat::create($data);

        if($request->file()) {
            $filename = $boat->name . '-' . time() . '-' . $request->picture->getClientOriginalName();
            $file = $boat->pictures()->create([
                'boat_id' => $boat->id,
                'picture' => $filename,
                'is_first' => 1,
            ]);
            $request->file('picture')->storeAs('boat/' . $boat->id, $file->id . '-' . $filename, 'public');
        }

        // if(isset($data['picture'])){

        //     foreach($data['picture'] as $key => $uploadedFile) {
        //         $filename = $boat->name . '-' . time() . '-' . $uploadedFile->getClientOriginalName();

        //         if($key == 0){
        //             $file = $boat->pictures()->create([
        //                 'boat_id' => $boat->id,
        //                 'picture' => $filename,
        //                 'is_first' => 1,
        //             ]);
        //         } else {
        //             $file = $boat->pictures()->create([
        //                 'boat_id' => $boat->id,
        //                 'picture' => $filename,
        //                 'is_first' => 0,
        //             ]);
        //         }

        //         $uploadedFile->storeAs('boat/' . $boat->id, $file->id . '-' . $filename, 'public');
        //     }
        // }

        // Add prices in Bdd
        // $periods = Period::get();

        // foreach ($periods as $period) {
        //     $data = $request->validate([
        //         'price' . $period->name . 'noskipper' => 'required|numeric',
        //         'price' . $period->name . 'withskipper' => 'required|numeric',
        //         'with_skipper0' => 'required|boolean',
        //         'with_skipper1' => 'required|boolean',
        //         'period_id' . $period->name => 'required',
        //     ]);

        //     $price_datas_noskipper = [
        //         'price' => $data['price' . $period->name . 'noskipper'],
        //         'with_skipper' => $data['with_skipper0'],
        //         'boat_id' => $boat->id,
        //         'period_id' => $data['period_id' . $period->name],
        //     ];
        //     $price_datas_withskipper = [
        //         'price' => $data['price' . $period->name . 'withskipper'],
        //         'with_skipper' => $data['with_skipper1'],
        //         'boat_id' => $boat->id,
        //         'period_id' => $data['period_id' . $period->name],
        //     ];

        //     BoatRentalPrice::create($price_datas_noskipper);
        //     BoatRentalPrice::create($price_datas_withskipper);
        // }

        // return redirect()->route('boat.index', app()->getLocale());
    }

    /**
     * @OA\Get(
     *      path="/boat/{id}",
     *      operationId="showBoat",
     *      tags={"Boats"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of boat",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Get details Of boat",
     *      description="Returns details Of boat",
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
        return new BoatResource(Boat::with(['pictures', 'boatRentalPrices', 'boatBookings'])->findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/boat/{id}",
     *      operationId="updateBoat",
     *      tags={"Boats"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of boat",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one boat",
     *      description="Update one boat",
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
            'description_fr' => 'required|max:10000',
            'description_en' => 'required|max:10000',
            'type_fr' => 'required|max:255',
            'type_en' => 'required|max:255',
            'displacements' => 'required|numeric',
            'surface' => 'required|numeric',
            'engine_power' => 'required|numeric',
            'hull_fr' => 'required|max:255',
            'hull_en' => 'required|max:255',
            'deck_fr' => 'required|max:255',
            'deck_en' => 'required|max:255',
            'mast_fr' => 'required|max:255',
            'mast_en' => 'required|max:255',
            'architect' => 'required|max:255',
            'diverse_fr' => 'required|max:255',
            'diverse_en' => 'required|max:255',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
            'description_fr.required' => 'You must give a french description to your boat',
            'description_en.required' => 'You must give an english description to your boat',
        ]
        );

        $boat = Boat::where('id', $id)->update($data);

        // $request->validate([
        //     'picture' => 'mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
        // ]);

        // if($request->file()) {
        //     $filename = $boat->name . '-' . time() . '-' . $request->picture->getClientOriginalName();
        //     $file = $boat->pictures()->create([
        //         'boat_id' => $boat->id,
        //         'picture' => $filename,
        //         'is_first' => 0,
        //     ]);
        //     $request->file('picture')->storeAs('boat/' . $boat->id, $file->id . '-' . $filename, 'public');
        //  }

        // $data_files = $request->validate([
        //     'filename_delete' => 'nullable|array',
        // ]);

        // if(!empty($data_files['filename_delete'])){

        //     Picture::whereIn('id', $data_files['filename_delete'])->delete();
        // }

        // $boat = Boat::where('id', $id)->find($id);

        // $data_files = $request->validate([
        //     'picture' => 'array',
        // ]);


        // if(isset($data_files['picture'])){

        //     foreach($data_files['picture'] as $uploadedFile) {
        //         $filename = $boat->name . '-' . time() . '-' . $uploadedFile->getClientOriginalName();

        //         $file = $boat->pictures()->create([
        //             'boat_id' => $boat->id,
        //             'picture' => $filename,
        //             'is_first' => 0,
        //         ]);

        //         $uploadedFile->storeAs('boat/' . $boat->id, $file->id . '-' . $filename, 'public');
        //     }
        // }

        // // Add prices in Bdd
        // $periods = Period::get();

        // foreach ($periods as $period) {
        //     $data = $request->validate([
        //         'price' . $period->name . 'noskipper' => 'required|numeric',
        //         'price' . $period->name . 'withskipper' => 'required|numeric',
        //         'with_skipper0' => 'required|boolean',
        //         'with_skipper1' => 'required|boolean',
        //         'period_id' . $period->name => 'required',
        //     ]);

        //     $price_datas_noskipper = [
        //         'price' => $data['price' . $period->name . 'noskipper'],
        //         'with_skipper' => $data['with_skipper0'],
        //         // 'boat_id' => $boat->id,
        //         'period_id' => $data['period_id' . $period->name],
        //     ];
        //     $price_datas_withskipper = [
        //         'price' => $data['price' . $period->name . 'withskipper'],
        //         'with_skipper' => $data['with_skipper1'],
        //         // 'boat_id' => $boat->id,
        //         'period_id' => $data['period_id' . $period->name],
        //     ];

        //     BoatRentalPrice::where('boat_id', $id)->where('period_id', $data['period_id' . $period->name])->where('with_skipper', $data['with_skipper0'])->update($price_datas_noskipper);
        //     BoatRentalPrice::where('boat_id', $id)->where('period_id', $data['period_id' . $period->name])->where('with_skipper', $data['with_skipper1'])->update($price_datas_withskipper);
        // }

        // return redirect()->route('boat.index', app()->getLocale());
    }

    /**
     * @OA\Delete(
     *      path="/boat/{id}",
     *      operationId="deleteBoat",
     *      tags={"Boats"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of boat",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Delete one boat",
     *      description="Delete one boat",
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
        return new BoatResource(Boat::findOrFail($id)->delete());
    }

/**
     * @OA\Post(
     *      path="/boat-booking",
     *      operationId="storeBoatBooking",
     *      tags={"Boat Booking"},

     *      summary="Store one boat booking",
     *      description="Store one boat booking",
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'with_skipper' => 'required|boolean',
            'description' => 'required|max:10000',
            'user_id' => 'required',
            'boat_id' => 'required',
        ]);

        // Enregistrement de la demande de reservation de bateau
        BoatBooking::create($data);

        $boat = Boat::find($data['boat_id']);

        $admins = User::where('admin', '1')->get();

        // Envoie de l'email à tous les admins
        foreach ($admins as $admin) {
            $admin->notify(new BoatBookingNotification($data, $boat));
        }
    }
}
