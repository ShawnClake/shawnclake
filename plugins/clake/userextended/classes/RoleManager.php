<?php

namespace Clake\UserExtended\Classes;


use Clake\Userextended\Models\GroupsExtended;

class RoleManager
{
    public $group;

    public $roles = [];

    public static function initGroupRolesByCode($code)
    {
        $instance = new static;
        $instance->group = GroupsExtended::where('code', $code)->first();
        if($instance->group != null)
            $instance->roles = $instance->group->roles;

        return $instance;
    }

    public function init()
    {
        $instance = new static;
        return $instance;
    }

    public function setGroup($code)
    {
        $this->group = GroupsExtended::where('code', $code)->first();
        if($this->group != null)
            $this->roles = $this->group->roles;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function all()
    {

    }

}