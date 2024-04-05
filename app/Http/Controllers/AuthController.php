<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'location' => 'nullable',
            'user_type' => 'nullable|in:AUDITEUR,ARTIST,PRODUCTEUR,EVENEMENT',
            'is_ghost_mode' => 'boolean',
            'favourites' => 'nullable',
            'follows' => 'nullable',
            'blocked' => 'nullable',
            'subscription_type' => 'nullable|in:AbonementEnum',
            'linked_accounts' => 'nullable',
            'artist_type' => 'nullable|in:CHANTEUR,MUSICIEN,BEATMAKER,DJ,GROUP',
            'producer_type' => 'nullable|in:STUDIO,CLIPPEUR,LABEL,SALLE',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'location' => $request->location,
            'user_type' => $request->user_type,
            'is_ghost_mode' => $request->is_ghost_mode,
            'favourites' => $request->favourites,
            'follows' => $request->follows,
            'blocked' => $request->blocked,
            'subscription_type' => $request->subscription_type,
            'linked_accounts' => $request->linked_accounts,
            'artist_type' => $request->artist_type,
            'producer_type' => $request->producer_type,
        ]);

        $token = $user->createToken('LaravelAuthApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('LaravelAuthApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}