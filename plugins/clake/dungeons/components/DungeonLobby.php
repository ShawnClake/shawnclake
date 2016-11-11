<?php namespace Clake\Dungeons\Components;

use Clake\DataStructures\Classes\Grid;
use Clake\Dungeons\Classes\DungeonManager;
use Clake\UserExtended\Classes\UserUtil;
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

    public function authorized()
    {
        if(!UserUtil::getLoggedInUser())
            return false;

        $slug = $this->property('dungeon');
        foreach(DungeonManager::load($slug, 'slug')->users() as $user)
        {
            if($user->id == UserUtil::getLoggedInUser()->id)
                return true;
        }
        return false;
    }

    public function players()
    {
        $slug = $this->property('dungeon');
        return DungeonManager::load($slug, 'slug')->players();
    }

    public function users()
    {
        $slug = $this->property('dungeon');
        return DungeonManager::load($slug, 'slug')->users();
    }

    public function characters()
    {
        $slug = $this->property('dungeon');
        return DungeonManager::load($slug, 'slug')->characters();
    }

    public function all()
    {
        $slug = $this->property('dungeon');
        $data = DungeonManager::load($slug, 'slug')->joined();
        $grid = Grid::init(2)->gridify($data);
        return [
            'cols' => $grid->getAllColStyleSize(),
            'data' => $grid->get()
        ];
    }

}