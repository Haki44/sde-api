<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoatBookingResource;
use App\Models\Boat;
use App\Models\BoatBooking;
use App\Models\User;
use App\Notifications\AcceptedBoatBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BoatBookingController extends Controller
{
    /**
     * @OA\Get(
     *      path="/boat-booking",
     *      operationId="IndexBoatBooking",
     *      tags={"Boat Booking"},

     *      summary="Get all boat booking",
     *      description="Get all boat booking",
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
        return BoatBookingResource::collection(BoatBooking::get());
    }

    /**
     * @OA\Get(
     *      path="/boat-booking/{id}",
     *      operationId="ShowBoatBooking",
     *      tags={"Boat Booking"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of boat booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Show one boat booking",
     *      description="Show one boat booking",
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
        return new BoatBookingResource(BoatBooking::findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/boat-booking/{id}",
     *      operationId="UpdateBoatBooking",
     *      tags={"Boat Booking"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of boat booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one boat booking",
     *      description="Update one boat booking",
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
        BoatBooking::where('id', $id)->update([
            'is_validate' => 1,
        ]);

        $boat_booking = BoatBooking::find($id);
        $user_to = User::find($boat_booking->user_id);
        $boat = Boat::find($boat_booking->boat_id);

        $user_to->notify(new AcceptedBoatBookingNotification($boat_booking, $user_to, $boat));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
