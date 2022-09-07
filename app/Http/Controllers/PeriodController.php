<?php

namespace App\Http\Controllers;

use App\Http\Resources\PeriodResource;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PeriodController extends Controller
{
    /**
     * @OA\Get(
     *      path="/period",
     *      operationId="IndexPeriod",
     *      tags={"Periods"},

     *      summary="Get all period",
     *      description="Get all period",
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
        return PeriodResource::collection(Period::get());
    }

    /**
     * @OA\Post(
     *      path="/period",
     *      operationId="StorePeriod",
     *      tags={"Periods"},

     *      summary="Store period",
     *      description="Store period",
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ],
        [
            'name.required' => 'You must indicate the name of the boat',
            'name.max' => 'The name of the boat is too long !',
        ]
        );

        Period::create($data);
    }

    /**
     * @OA\Put(
     *      path="/period/{id}",
     *      operationId="UpdatePeriod",
     *      tags={"Periods"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of period",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one period",
     *      description="Update one period",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
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
     * @OA\Delete(
     *      path="/period/{id}",
     *      operationId="DeletePeriod",
     *      tags={"Periods"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of period",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Delete one period",
     *      description="Delete one period",
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
        return new PeriodResource(Period::findOrFail($id)->delete());
    }
}
