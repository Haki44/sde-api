<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'token' => $user->createToken(time())->plainTextToken
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'nationality' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tel' => ['string', 'min:2', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'nationality' => $request->nationality,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
        ]);
        // $data = $request->validate([
        //     'name' => 'required',
        //     'firstname' => 'required',
        //     'nationality' => 'required',
        //     'tel' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        // $deck = Deck::create($data);
    }

    public function getRole()
    {
        return response()->json([
            'is_admin' => auth()->user()->admin
        ]);
    }

    public function getAuthUser()
    {
        return response()->json([
            auth()->user()
        ]);
    }

    public function logout()
    {
        //
    }
}
