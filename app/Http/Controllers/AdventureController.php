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
    public function index()
    {
        return AdventureResource::collection(Adventure::with(['pictures'])->paginate(30));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::get();

        return view('adventure.create', compact('levels'));
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
     * Display the specified resource.
     *
     * @param  \App\Models\Adventure  $adventure
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AdventureResource(Adventure::with(['pictures', 'level'])->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adventure  $adventure
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $adventure = Adventure::with('pictures')->find($id);

        $levels = Level::get();

        return view('adventure.edit', compact('lang', 'adventure', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adventure  $adventure
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adventure  $adventure
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new AdventureResource(Adventure::findOrFail($id)->delete());
    }

    // public function booking($lang, $id)
    // {
    //     $adventure = Adventure::find($id);
    //     return view('adventure.booking', compact('lang', 'adventure'));
    // }

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

        // return redirect()->route('adventure.index', app()->getLocale())->with('success', 'Your advenure reservation request has been sent, you will be contacted soon');
    }
}
