<?php

namespace Clake\UserExtended\Classes;

use Clake\Userextended\Models\GroupsExtended;
use October\Rain\Support\Collection;

/**
 * Class GroupManager
 *
 * Handles all interaction accross groups on a global level rather than a user level.
 * @method static GroupManager allGroups GroupManager
 * @package Clake\UserExtended\Classes
 */
class GroupManager extends StaticFactory
{

    /**
     * A collection of groups
     * @var
     */
    private $groups;

    /**
     * @param $code
     * @deprecated Renamed to a better name below.
     * @return mixed
     */
    public static function retrieve($code)
    {
        return GroupsExtended::where('code', $code)->first();
    }

    /**
     * Returns a group model where the group code is: code=$code
     * @param $code
     * @return mixed
     */
    public static function findGroup($code)
    {
        return GroupsExtended::where('code', $code)->first();
    }

    /**
     * Creates and fills the class with all of the groups that exist in the applciation
     * @deprecated Renamed below and adds factory support
     * @return static
     */
    public function all()
    {
        $this->groups = new Collection();

        $groups = GroupsExtended::all();

        foreach($groups as $group)
        {
            $this->groups->put($group->code, $group);
        }

        return $this;
    }

    /**
     * Creates and fills the class with all of the groups that exist in the applciation
     * @return $this
     */
    public function allGroupsFactory()
    {
        $this->groups = new Collection();

        $groups = GroupsExtended::all();

        foreach($groups as $group)
        {
            $this->groups->put($group->code, $group);
        }

        return $this;
    }

    /**
     * Returns a count of how many groups there are
     * @deprecated Renamed to follow RoleManager format
     * @return mixed
     */
    public function count()
    {
        return $this->groups->count();
    }

    /**
     * Returns a count of how many groups there are
     * @return mixed
     */
    public function countGroups()
    {
        return $this->groups->count();
    }

    /**
     * Returns a count of how many roles there are in a specific group.
     * @param $groupCode
     * @deprecated Renamed below and added better error checking
     * @return mixed
     */
    public function roleCount($groupCode)
    {
        return $this->groups->get($groupCode)->roles()->count();
    }

    /**
     * Returns a count of how many roles there are in a specific group.
     * @param $groupCode
     * @return bool
     */
    public function countGroupRoles($groupCode)
    {
        if(empty($this->groups))
            return false;
        return $this->groups->get($groupCode)->roles()->count();
    }

    /**
     * Returns the collection of groups.
     * @deprecated Renamed below to a better name
     * @return mixed
     */
    public function get()
    {
        return $this->groups;
    }

    /**
     * Returns the collection of groups.
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

}