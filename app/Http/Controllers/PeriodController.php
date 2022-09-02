<?php

namespace App\Http\Controllers;

use App\Http\Resources\PeriodResource;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PeriodResource::collection(Period::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('period.create');
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
        ]
        );

        Period::create($data);

        return redirect()->route('period.index', app()->getLocale());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $period = Period::find($id);

        return view('period.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
        ]
        );

        Period::where('id', $id)->update($data);

        return redirect()->route('period.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        Period::find($id)->delete();

        return redirect()->route('period.index', app()->getLocale());
    }
}
