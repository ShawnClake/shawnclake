<?php namespace Clake\Dungeons\Components;

use Clake\Dungeons\Classes\DungeonManager;
use Cms\Classes\ComponentBase;

class DungeonList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'DungeonList',
            'description' => 'Lists the active dungeons'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function dungeons()
    {
        return DungeonManager::dungeons(5);
    }

}