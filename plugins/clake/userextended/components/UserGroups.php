<?php namespace Clake\UserExtended\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Clake\UserExtended\Classes\UserGroupManager;

/**
 *
 */

/**
 * Class UserGroups
 * @package Clake\UserExtended\Components
 * @deprecated Please use UserExtended.User
 */
class UserGroups extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'DEPRECIATED. User groups list',
            'description' => 'Returns a list of UserGroups'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * Returns a list of user groups to the page in a variable called 'groups'
     */
	public function onRun() 
	{
        $this->page['groups'] = UserGroupManager::currentUser()->allGroups()->getUsersGroups();
	}

}