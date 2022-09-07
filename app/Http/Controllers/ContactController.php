<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *      path="/contact",
     *      operationId="IndexContact",
     *      tags={"Contact"},

     *      summary="Get all contact",
     *      description="Get all contact",
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
        return ContactResource::collection(Contact::get());
    }

    /**
     * @OA\Get(
     *      path="/contact/{id}",
     *      operationId="ShowContact",
     *      tags={"Contact"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of contact",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Show one contact",
     *      description="Show one contact",
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
        return new ContactResource(Contact::findOrFail($id));
    }

    /**
     * @OA\Put(
     *      path="/contact/{id}",
     *      operationId="UpdateContact",
     *      tags={"Contact"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of contact",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),

     *      summary="Update one contact",
     *      description="Update one contact",
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
        Contact::where('id', $id)->update([
            'is_validate' => 1,
        ]);
    }

    /**
     * @OA\Post(
     *      path="/contact",
     *      operationId="StoreContact",
     *      tags={"Contact"},

     *      summary="Store one contact",
     *      description="Store one contact",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function send_contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'firstname' => 'required|max:255',
            'email' => 'required|email',
            'tel' => 'required',
            'description' => 'required|max:10000',
        ]);

        Contact::create($data);

        $admins = User::where('admin', '1')->get();

        // Envoie de l'email à tous les admins
        foreach ($admins as $admin) {
            $admin->notify(new ContactNotification($data));
        }
    }
}
