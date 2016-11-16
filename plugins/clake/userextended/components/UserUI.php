<?php namespace Clake\Userextended\Components;

use Clake\UserExtended\Classes\FriendsManager;
use Clake\UserExtended\Classes\UserUtil;
use Cms\Classes\ComponentBase;

class UserUI extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'User UI',
            'description' => 'Provides generic interface implementations'
        ];
    }

    public function defineProperties()
    {
        return [
            'user' => [
                'title'             => 'User',
                'description'       => 'The user id for the user',
                'default'           => ':user',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ]
        ];
    }

    /**
     * Provides user information to the page
     * @return mixed
     */
    public function user()
    {
        $userid = $this->property('user');

        return UserUtil::getUser($userid);
    }

    /**
     * Returns whether or not the user is our friend and thus
     * whether or not the page should be partially restricted
     * @return bool
     */
    public function unrestricted()
    {
        $userid = $this->property('user');

        return (FriendsManager::isFriend($userid)) || (UserUtil::getLoggedInUser()->id == $userid);
    }

    /**
     * AJAX call for when someone wants to send a friend request
     */
    public function onFriendUser()
    {
        $userid = $this->property('user');

        FriendsManager::sendFriendRequest($userid);
    }


}