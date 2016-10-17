<?php namespace Clake\Dungeons\Components;

use Clake\Dungeons\Classes\DungeonManager;
use Cms\Classes\ComponentBase;

class DungeonLobby extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'DungeonLobby',
            'description' => 'Provides dungeon lobby info'
        ];
    }

    public function defineProperties()
    {
        return [
            'dungeon' => [
                'title'             => 'Dungeon',
                'description'       => 'The slug for the dungeon',
                'default'           => ':dungeon',
                'type'              => 'string',
            ]
        ];
    }

    public function dungeon()
    {
        $slug = $this->property('dungeon');
        return DungeonManager::load($slug, 'slug')->get();
    }

    public function players()
    {
        $slug = $this->property('dungeon');
        return json_encode(DungeonManager::load($slug, 'slug')->players());
    }

    public function users()
    {
        $slug = $this->property('dungeon');
        return json_encode(DungeonManager::load($slug, 'slug')->users());
    }

    public function characters()
    {
        $slug = $this->property('dungeon');
        return json_encode(DungeonManager::load($slug, 'slug')->characters());
    }

}