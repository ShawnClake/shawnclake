<?php namespace Clake\Userextended\Components;

use Clake\Userextended\Models\Friends;
use Cms\Classes\ComponentBase;
use Auth;
use Illuminate\Support\Collection;
use RainLab\User\Models\User;

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

        $userid = self::getLoggedInUser()->id;

        $limit = $this->property('maxItems');

        $usersa = new Collection;

        $usersb = new Collection;

        $friendsa = Friends::where('user_that_sent_request', $userid)->take($limit)->get();

        //$friendsa = $friendsa->keyBy('user_that_accepted_request');

        //$friendsa = $friendsa->keyBy(function($item) { return "U" . $item['user_that_accepted_request']; });

        foreach ($friendsa as $result) {

            $u = User::where('id', $result['user_that_accepted_request'])->get();
            $usersa->push($u[0]);

        }

        $friendsb = Friends::where('user_that_accepted_request', $userid)->take($limit)->get();

        //$friendsb = $friendsb->keyBy('user_that_sent_request');

        //$friendsb = $friendsb->keyBy(function($item) { return "U" . $item['user_that_sent_request']; });

        foreach ($friendsb as $result) {

            $u = User::where('id', $result['user_that_sent_request'])->get();
            $usersb->push($u[0]);

        }

        $users = $usersa->merge($usersb);

        $users = $users->shuffle();

        $users = $users->take($limit);

        return $users;

    }

    private static function getLoggedInUser()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        $user->touchLastSeen();

        return $user;
    }


}