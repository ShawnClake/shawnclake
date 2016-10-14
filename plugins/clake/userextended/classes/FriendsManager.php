<?php

namespace Clake\UserExtended\Classes;

use Clake\Userextended\Models\Friends;
use Auth;
use Illuminate\Support\Collection;
use RainLab\User\Models\User;

class FriendsManager
{


    public static function listMyReceivedFriendRequests($userid = null, $limit = 5)
    {

        $users = new Collection();

        if($userid == null)
            $userid = self::getLoggedInUser()->id;

        $requests = Friends::where('user_that_accepted_request', $userid)->where('accepted', 0)->take($limit)->get();

        foreach ($requests as $request) {

            $u = User::where('id', $request['user_that_sent_request'])->get();
            $users->push($u[0]);

        }

        return $users;

    }

    public static function sendFriendRequest($friendUserID)
    {

        $exists = Friends::where('user_that_sent_request', self::getLoggedInUser()->id)->where('user_that_accepted_request', $friendUserID)->count();

        $exists2 = Friends::where('user_that_accepted_request', self::getLoggedInUser()->id)->where('user_that_sent_request', $friendUserID)->count();

        if($exists > 0 || $exists2 > 0)
            return;

        $request = new Friends;

        $request->user_that_sent_request = self::getLoggedInUser()->id;

        $request->user_that_accepted_request = $friendUserID;

        $request->accepted = 0;

        $request->save();

    }

    public static function isFriend($userID1, $userID2 = null)
    {

        if($userID2 == null)
            $userID2 = self::getLoggedInUser()->id;

        $friendsa = Friends::where('user_that_sent_request', $userID1)->where('user_that_accepted_request', $userID2)->where('accepted', '1')->count();

        if($friendsa > 0)
            return true;

        $friendsb = Friends::where('user_that_sent_request', $userID2)->where('user_that_accepted_request', $userID1)->where('accepted', '1')->count();

        if($friendsb > 0)
            return true;

        return false;

    }

    public static function acceptRequest($userID1, $userID2 = null)
    {

        if($userID2 == null)
            $userID2 = self::getLoggedInUser()->id;

        $friends = Friends::where('user_that_sent_request', $userID1)->where('user_that_accepted_request', $userID2)->where('accepted', '0')->count();

        if($friends == 1)
        {

            $request = Friends::where('user_that_sent_request', $userID1)->where('user_that_accepted_request', $userID2)->where('accepted', '0')->get();
            $request = $request[0];
            $request->accepted = 1;
            $request->save();

        }

    }

    public static function listRequests($limit = 100)
    {
        $userid = self::getLoggedInUser()->id;

        $usersa = new Collection;

        $usersb = new Collection;

        $friendsa = Friends::where('user_that_sent_request', $userid)->where('accepted', '0')->take($limit)->get();

        //$friendsa = $friendsa->keyBy('user_that_accepted_request');

        //$friendsa = $friendsa->keyBy(function($item) { return "U" . $item['user_that_accepted_request']; });

        foreach ($friendsa as $result) {

            $u = User::where('id', $result['user_that_accepted_request'])->get();
            $usersa->push($u[0]);

        }

        $friendsb = Friends::where('user_that_accepted_request', $userid)->where('accepted', '0')->take($limit)->get();

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

    public static function listFriends($limit)
    {

        $userid = self::getLoggedInUser()->id;

        $usersa = new Collection;

        $usersb = new Collection;

        $friendsa = Friends::where('user_that_sent_request', $userid)->where('accepted', '1')->take($limit)->get();

        //$friendsa = $friendsa->keyBy('user_that_accepted_request');

        //$friendsa = $friendsa->keyBy(function($item) { return "U" . $item['user_that_accepted_request']; });

        foreach ($friendsa as $result) {

            $u = User::where('id', $result['user_that_accepted_request'])->get();
            $usersa->push($u[0]);

        }

        $friendsb = Friends::where('user_that_accepted_request', $userid)->where('accepted', '1')->take($limit)->get();

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

    public static function getAll()
    {
        $userid = self::getLoggedInUser()->id;

        $usersa = new Collection;

        $usersb = new Collection;

        $friendsa = Friends::where('user_that_sent_request', $userid)->where('accepted', '1')->get();

        //$friendsa = $friendsa->keyBy('user_that_accepted_request');

        //$friendsa = $friendsa->keyBy(function($item) { return "U" . $item['user_that_accepted_request']; });

        foreach ($friendsa as $result) {

            $u = User::where('id', $result['user_that_accepted_request'])->get();
            $usersa->push($u[0]);

        }

        $friendsb = Friends::where('user_that_accepted_request', $userid)->where('accepted', '1')->get();

        //$friendsb = $friendsb->keyBy('user_that_sent_request');

        //$friendsb = $friendsb->keyBy(function($item) { return "U" . $item['user_that_sent_request']; });

        foreach ($friendsb as $result) {

            $u = User::where('id', $result['user_that_sent_request'])->get();
            $usersb->push($u[0]);

        }

        $users = $usersa->merge($usersb);

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