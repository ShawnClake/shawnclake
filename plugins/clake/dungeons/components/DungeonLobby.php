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
        return DungeonManager::get('slug', $slug);
    }

    public function players()
    {
        $slug = $this->property('dungeon');
        return json_encode(DungeonManager::players(DungeonManager::get('slug', $slug)));
    }

    public function users()
    {
        $slug = $this->property('dungeon');
        return json_encode(DungeonManager::users(DungeonManager::get('slug', $slug)));
    }

}