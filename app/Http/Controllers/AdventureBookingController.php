<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdventureBookingResource;
use App\Models\Adventure;
use App\Models\AdventureBooking;
use App\Models\User;
use App\Notifications\AcceptedAdventureBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdventureBookingController extends Controller
{
    /**
     * @OA\Get(
     *      path="/adventure-booking",
     *      operationId="IndexAdventureBooking",
     *      tags={"Adventure Booking"},

     *      summary="Get all adventure booking",
     *      description="Get all adventure booking",
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
        return AdventureBookingResource::collection(AdventureBooking::get());
    }

    /**
     * @OA\Get(
     *      path="/adventure-booking/{id}",
     *      operationId="ShowAdventureBooking",
     *      tags={"Adventure Booking"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of adventure booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Show one adventure booking",
     *      description="Show one adventure booking",
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
        return new AdventureBookingResource(AdventureBooking::findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/adventure-booking/{id}",
     *      operationId="UpdateAdventureBooking",
     *      tags={"Adventure Booking"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of adventure booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one adventure booking",
     *      description="Update one adventure booking",
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
        AdventureBooking::where('id', $id)->update([
            'is_validate' => 1,
        ]);

        $adventure_booking = AdventureBooking::find($id);
        $user_to = User::find($adventure_booking->user_id);
        $adventure = Adventure::find($adventure_booking->adventure_id);

        $user_to->notify(new AcceptedAdventureBookingNotification($adventure_booking, $user_to, $adventure));

        // return redirect()->route('adventure-booking.index', app()->getLocale())->with('success', 'Request of ' . $adventure_booking->name . ' has been processed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdventureBooking  $adventureBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdventureBooking $adventureBooking)
    {
        //
    }
}
