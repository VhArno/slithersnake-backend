<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkinResource;
use App\Http\Resources\GamemodeResource;
use App\Http\Resources\MapResource;
use App\Models\Duel;
use App\Models\User;
use App\Models\Gamemode;
use App\Models\Map;
use App\Models\Skin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GameController extends Controller
{
    // Skins functions
    function getSkin(int $id) {
        return new SkinResource(Skin::findOrFail($id));
    }

    function getAllSkins() {
        return SkinResource::collection(Skin::all());
    }

    function getFeaturedSkins() {
        return SkinResource::collection(Skin::where('featured', 'true')->get());
    }

    // Gamemodes functions
    function getGamemode(int $id) {
        return new GamemodeResource(Gamemode::findOrFail($id));
    }

    function getGamemodes() {
        return GamemodeResource::collection(Gamemode::all());
    }

    // Maps function
    function getMap(int $id) {
        return new MapResource(Map::findOrFail($id));
    }

    function getMaps() {
        return MapResource::collection(Map::all());
    }

    // Duels function
    function createDuels(Request $request) {
        $validator = Validator::make($request->all(), [
            'gamemodes_id' => 'required|numeric|exists:gamemodes,id',
            'maps_id' => 'required|numeric|exists:maps,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid request data'], 422);
        }

        $duel = new Duel();

        $duel->start_time = Carbon::now();
        $duel->end_time = null;
        $duel->gamemodes_id = $request->input('gamemodes_id');
        $duel->maps_id = $request->input('maps_id');

        $duel->save();

        return response()->json(['message' => 'Duel has been created', 'data' => ['duel_id' => $duel->id]], 201);
    }

    function patchDuel(Request $request) {
        $validator = Validator::make($request->all(), [
            'duel_id' => 'required|numeric|exists:duels,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid request data'], 422);
        }

        $duel = Duel::findOrFail($request->input('duel_id'));

        if($duel->end_time == null) {
            $duel->end_time = Carbon::now();
            $duel->save();
        } else {
            return response()->json(['message' => 'Duel has already been concluded'], 200);
        }
        

        return response()->json(['message' => 'Duel enddate has been set'], 200);
    }

    function addDuelUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'duel_id' => 'required|numeric|exists:duels,id',
            'score' => 'required|numeric',
            'won' => 'required|boolean',
            'kills' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid request data'], 422);
        }

        $user = $request->user();
        $duel = Duel::find($request->input('duel_id'));

        $pivotData = [
            'score' => $request->input('score'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $user->duels()->attach($duel->id, $pivotData);

        // update user stats
        $score = $request->score;

        $baseProbability = 0.1; // 10% base chance
        $scalingFactor = 0.005; // 0.5% additional chance per point of score
    
        $probability = $baseProbability + ($scalingFactor * $score);
    
        if ($probability > 1) {
            $probability = 1;
        }
    
        $randomFloat = mt_rand() / mt_getrandmax();
    
        if ($randomFloat < $probability) {
            $user->level += 1;// Increase the user's level
        }

        $user->highscore = $user->highscore < $request->input('score') ? $request->input('score') : $user->highscore;
        $user->games_played += 1;
        if($request->input('won') == true) $user->games_won += 1;
        $user->players_killed += $request->input('kills');
        $user->save();

        return response()->json(['message' => 'User has been added to duel'], 201);
    }
}
