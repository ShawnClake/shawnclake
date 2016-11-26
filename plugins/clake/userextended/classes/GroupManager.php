<?php
/**
 * Created by PhpStorm.
 * User: Shawn
 * Date: 11/26/2016
 * Time: 1:04 PM
 */

namespace Clake\UserExtended\Classes;


use Clake\Userextended\Models\GroupsExtended;
use October\Rain\Support\Collection;

class GroupManager
{

    private $groups;

    public static function all()
    {
        $instance = new static;

        $instance->groups = new Collection();

        $groups = GroupsExtended::all();

        foreach($groups as $group)
        {
            $instance->groups->put($group->code, $group);
        }

        return $instance;
    }

    public function count()
    {
        return $this->groups->count();
    }

    public function roleCount($groupCode)
    {
        return $this->groups->get($groupCode)->roles()->count();
    }

}