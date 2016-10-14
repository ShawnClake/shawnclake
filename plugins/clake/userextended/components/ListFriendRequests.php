<?php namespace Clake\Userextended\Components;

use Clake\UserExtended\Classes\FriendsManager;
use Cms\Classes\ComponentBase;

class ListFriendRequests extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ListFriendRequests Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title'             => 'Max items',
                'description'       => 'The most amount of friend requests to show',
                'default'           => 5,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ],
        ];
    }


    public function friendrequests()
    {
        $limit = $this->property('maxItems');

        return FriendsManager::listMyReceivedFriendRequests(null, $limit);
    }

    public function onAccept()
    {
        $userid = post('id');

        FriendsManager::acceptRequest($userid);

    }

}