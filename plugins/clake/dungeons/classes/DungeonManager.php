<?php

namespace Clake\Dungeons\Classes;

use Clake\Dungeons\Models\Dungeons;
use Illuminate\Support\Collection;
use RainLab\User\Models\User;

class DungeonManager
{

    private $dungeon;

    public static function load($value, $column = 'id')
    {
        $o = new static;

        $o->dungeon = Dungeons::where($column, $value)->first();

        return $o;
    }

    public static function getDungeon($id)
    {
        return Dungeons::where('id', $id)->first();
    }

    public function get()
    {
        return $this->dungeon;
    }

    public static function dungeons($limit = 100)
    {
        return Dungeons::take($limit)->get();
    }

    public function players()
    {
        return $this->dungeon->players;
    }

    public function users()
    {
        $users = new Collection;

        $players =self::players($this->dungeon);

        foreach($players as $player)
        {
            $users->push($player->user);
        }

        return $users;

    }

    public function characters()
    {
        $characters = new Collection;

        $players =self::players($this->dungeon);

        foreach($players as $player)
        {
            $characters->push($player->character);
        }

        return $characters;
    }

}