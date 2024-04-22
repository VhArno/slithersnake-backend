<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkinResource;
use App\Http\Resources\GamemodeResource;
use App\Http\Resources\MapResource;
use App\Models\Gamemode;
use App\Models\Map;
use App\Models\Skin;
use Illuminate\Http\Request;

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
    function createDuels() {

    }
}
