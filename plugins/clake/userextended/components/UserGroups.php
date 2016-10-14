<?php namespace Clake\UserExtended\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Clake\UserExtended\Classes\UserGroupManager;

class UserGroups extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'UserGroups Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
	
	public function onRun() 
	{

        $this->page['groups'] = UserGroupManager::CurrentUser()->All()->Get(); //$usergroup->users()->get();

	}

}