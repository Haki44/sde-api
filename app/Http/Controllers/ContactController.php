<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = App::getLocale();

        return view('contact', compact('lang'));
    }

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
