<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkinResource;
use App\Http\Resources\GamemodeResource;
use App\Http\Resources\MapResource;
use App\Models\Duel;
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
    function addDuelUser() {
        
    }

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
    }

    function patchDuel(Request $request) {
        $validator = Validator::make($request->all(), [
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid request data'], 422);
        }

        $duel = new Duel();
        $duel->end_time = Carbon::now();
    }
}
