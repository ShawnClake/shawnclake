<?php

namespace Clake\UserExtended\Classes;

use Clake\UserExtended\Models\GroupsExtended;
use Clake\Userextended\Models\Roles;
use Clake\Userextended\Models\UsersGroups;
use Clake\UserExtended\Plugin;

class UserRoleManager
{

    private $userRoles;

    private $user;

    public static function using($user = null)
    {
        $instance = new static;

        if($user == null) {
            $user = UserUtil::getLoggedInUser();
        }

        $instance->user = $user;

        return $instance;
    }

    public static function currentUser()
    {
        $instance = new static;

        $instance->user = UserUtil::getLoggedInUser();

        return $instance;
    }

    public function get()
    {
        return $this->userRoles;
    }

    public function all()
    {
        $roles = UserUtil::castToUserExtendedUser($this->user)->roles;
        $userRoles = [];

        foreach($roles as $role)
        {
            $userRoles[strtolower($role->group->code)] = $role;
        }

        $this->userRoles = $userRoles;



        return $this;
    }

    public function isInRole($roleCode, $roles = null)
    {
        if($roles == null)
            $roles = $this->userRoles;

        return array_key_exists(strtolower($roleCode), $roles);
    }

    public function getGroupRolesByOrdering(GroupsExtended $group)
    {
        $roles = $group->roles;
        $groupRoles = [];

        foreach($roles as $role)
        {
            $groupRoles[$role["sort_order"]] = $role;
        }

        ksort($groupRoles);

        return $groupRoles;
    }

    public function saveRoles()
    {
        $userid = $this->user->id;

        foreach($this->userRoles as $role)
        {
            $pivot = UsersGroups::where('user_id', $userid)->where('user_group_id', $role->group->id)->first();
            $pivot->role_id = $role->id;
            $pivot->save();
        }

        return $this;
    }

    public function promote($groupCode)
    {
        if(!UserGroupManager::CurrentUser()->All()->IsInGroup($groupCode))
            return;

        $role = $this->userRoles[strtolower($groupCode)];
        $roleGroup = $role->group;

        $roles = $this->getGroupRolesByOrdering($roleGroup);

        $newRole = $roles[$role->sort_order - 1];

        $this->userRoles[strtolower($groupCode)] = $newRole;

        $this->saveRoles();

        return $this;
    }

}