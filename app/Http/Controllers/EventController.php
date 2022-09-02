<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Boat;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EventResource::collection(Event::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'boat_id' => 'required|numeric',
        ]);

        // on ajoute un jour pour avoir le bon affichage sur le calendrier car dernier jour n'est pas inclut
        // $data['end'] = date("Y-m-d", strtotime($data['end'].'+ 1 days'));
        // $data['boat_id'] = $id;

        Event::create($data);

        // return redirect()->route('event.index', [app()->getLocale(), $id])->with('success', 'La date à bien été ajoutée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EventResource(Event::findOrFail($id));
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new EventResource(Event::findOrFail($id)->delete());
    }
}
