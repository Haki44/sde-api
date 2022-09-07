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
    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Authentification"},

     *      summary="Login to the API",
     *      description="Login to the API",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function authenticate(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'token' => $user->createToken(time())->plainTextToken
            ]);
        }
    }

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"Authentification"},

     *      summary="Register to the API",
     *      description="Register to the API",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
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
    }

    /**
     * @OA\Get(
     *      path="/getRole",
     *      operationId="role",
     *      tags={"Auth User informations"},

     *      summary="Get role to the authentificate user",
     *      description="Get role to the authentificate user",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function getRole()
    {
        return response()->json([
            'is_admin' => auth()->user()->admin
        ]);
    }

    /**
     * @OA\Get(
     *      path="/getAuthUser",
     *      operationId="AuthUser",
     *      tags={"Auth User informations"},

     *      summary="Get all infos to the authentificate user",
     *      description="Get all infos to the authentificate user",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *  )
     */
    public function getAuthUser()
    {
        return response()->json([
            auth()->user()
        ]);
    }
}
