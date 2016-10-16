<?php

namespace Clake\Dungeons\Classes;

use Clake\Dungeons\Models\Dungeons;
use Illuminate\Support\Collection;
use RainLab\User\Models\User;

class DungeonManager
{

    public static function getDungeon($id)
    {
        return Dungeons::where('id', $id)->first();
    }

    public static function get($column, $value)
    {
        return Dungeons::where($column, $value)->first();
    }

    public static function dungeons($limit = 100)
    {
        return Dungeons::take($limit)->get();
    }

    public static function players(Dungeons $dungeon)
    {
        return $dungeon->players;
    }

    public static function users(Dungeons $dungeon)
    {
        $users = new Collection;

        $players =self::players($dungeon);

        foreach($players as $player)
        {
            $users->push($player->user);
        }

        return $users;

    }

}