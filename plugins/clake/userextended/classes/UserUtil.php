<?php

namespace Clake\UserExtended\Classes;

use Auth;

class UserUtil
{
    public static function getLoggedInUser()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        $user->touchLastSeen();

        return $user;
    }
}