<?php namespace Clake\Userextended\Components;

use Clake\UserExtended\Classes\FriendsManager;
use Clake\UserExtended\Classes\UserManager;
use Cms\Classes\ComponentBase;

class ListFriends extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ListFriends Component',
            'description' => 'List a users friends'
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title'             => 'Max items',
                'description'       => 'The most amount of friends to show',
                'default'           => 5,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ]
        ];
    }

    public function friends()
    {

        $limit = $this->property('maxItems');

        return FriendsManager::listFriends($limit);

    }

    public function listRandomUsers()
    {
        return UserManager::getRandomUserSet(5);
    }

}