<?php

namespace Clake\UserExtended\Classes;
use Illuminate\Support\Collection;
use RainLab\User\Models\User;

class UserManager
{
    public static function getRandomUserSet($limit = 5)
    {

        $users = new Collection;
        $returner = new Collection;

        $userCount = User::all()->count();

        if($userCount < $limit)
            $limit = $userCount;

        $users = User::all()->random($limit);

        $friends = FriendsManager::getAll();

        foreach($users as $user)
        {

            $userAdd = true;

            foreach($friends as $friend)
            {

                if($user->id == $friend->id)
                {
                    $userAdd = false;
                    break;
                }

            }

            if($user->id == UserUtil::getLoggedInUser()->id)
                $userAdd = false;

            if($userAdd)
            {
                $returner->push($user);
            }

        }

        return $returner;

    }
}