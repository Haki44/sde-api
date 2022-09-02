<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BoatBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = App::getLocale();

        $boat_bookings = BoatBooking::get();

        $boats = Boat::get();

        return view('boat-booking.index', compact('lang', 'boat_bookings', 'boats'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id)
    {
        // dd($id);
        $boat_booking = BoatBooking::find($id);
        $boats = Boat::get();

        return view('boat-booking.show', compact('lang', 'boat_booking', 'boats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        BoatBooking::where('id', $id)->update([
            'is_validate' => 1,
        ]);

        $boat_booking = BoatBooking::find($id) ;

        return redirect()->route('boat-booking.index', app()->getLocale())->with('success', 'Request of ' . $boat_booking->name . ' has been processed');
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
