<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): Response {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response(['message' => 'The user has been authenticated successfully'], 200);
        }
        return response(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request): Response {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return response(['message' => 'The user has been logged out successfully'], 200);
    }

    public function getUser(Request $request): User {
        return $request->user();
    }

    public function createUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:100',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'User creation failed'], 422);
        }

        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->save();

        return response()->json(['message' => 'User has been created'], 201);
    }
}
