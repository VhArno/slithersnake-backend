<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request): Response {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response(['message' => 'The user has been authenticated successfully'], 200);
        }
        return response(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request): Response {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return response(['message' => 'The user has been logged out successfully'], 200);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'level' => 'nullable|numeric',
            'highscore' => 'nullable|numeric',
            'games_played' => 'nullable|numeric',
            'games_won' => 'nullable|numeric',
            'players_killed' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->level = 1;
        $user->highscore = 0;
        $user->games_played = 0;
        $user->games_won = 0;
        $user->players_killed = 0;

        $user->save();

        $pivotData = [
            'unlocked_at' => Carbon::now(),
        ];
        foreach(Skin::all() as $skin) {
            $user->skins()->attach($skin->id, $pivotData);
        }

        $user->save();

        return response()->json(['message' => 'User has been created'], 201);
    }

    public function getUser(Request $request) {
        return new UserResource($request->user());
    }

    public function patchUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|unique:users',
            'email' => 'nullable|string|email|unique:users',
            /*'level' => 'nullable|numeric',
            'highscore' => 'nullable|numeric',
            'games_played' => 'nullable|numeric',
            'games_won' => 'nullable|numeric',
            'players_killed' => 'nullable|numeric',*/
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $user = $request->user();

        if ($request->filled('username')) $user->username = $request->input('username');
        if ($request->filled('email')) $user->email = $request->input('email');
        
        /*if ($request->filled('level')) $user->level = $request->input('level');
        if ($request->filled('highscore')) $user->highscore = $request->input('highscore');
        if ($request->filled('games_played')) $user->games_played = $request->input('games_played');
        if ($request->filled('games_won')) $user->games_won = $request->input('games_won');
        if ($request->filled('players_killed')) $user->players_killed = $request->input('players_killed');*/

        $user->save();

        return response()->json(['message' => 'User updated', 200]);
    }

    public function deleteUser(Request $request) {
        $user = $request->user();
        $user->delete();
        return response(['message' => 'User deleted'], 200);
    }

    public function getLeaderboard(Request $request) {
        $validator = Validator::make($request->all(), [
            'sort' => 'nullable|string|in:level,highscore,winrate',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $query = User::query();

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'level':
                    $query->orderBy('level', 'desc');
                    break;
                case 'highscore':
                    $query->orderBy('highscore', 'desc');
                    break;
                case 'winrate':
                    $query->orderBy(DB::raw('IF(games_played = 0, 0, (games_won / games_played))'), 'desc');
                break;
            }
        } else {
            $query->orderBy('highscore', 'desc');
        }        

        return response()->json(['data' => UserResource::collection($query->take(10)->get())]);
    }
}
