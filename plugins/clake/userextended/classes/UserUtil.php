<?php namespace Clake\UserExtended\Classes;

use Auth;
use Carbon\Carbon;
use Clake\Userextended\Models\UserExtended;
use RainLab\User\Models\User;
use Redirect;

/**
 * User Extended by Shawn Clake
 * Class UserUtil
 * User Extended is licensed under the MIT license.
 *
 * @author Shawn Clake <shawn.clake@gmail.com>
 * @link https://github.com/ShawnClake/UserExtended
 *
 * @license https://github.com/ShawnClake/UserExtended/blob/master/LICENSE MIT
 * @package Clake\UserExtended\Classes
 */
class UserUtil
{

    /**
     * Get all users with the search criteria
     * @param $value
     * @param string $property
     * @return mixed
     */
    public static function getUsers($value, $property = "name")
    {
        return User::where($property, $value)->get();
    }

    /**
     * Get the first user with the search criteria
     * @param $value
     * @param string $property
     * @return mixed
     */
    public static function getUser($value, $property = "id")
    {
        return UserExtended::where($property, $value)->first();
    }

    /**
     * Get the rainlab user instance.
     * Required for backward compatibility with relations like 'avatar'
     * @param $value
     * @param string $property
     * @return mixed
     */
    public static function getRainlabUser($value, $property = "id")
    {
        return User::where($property, $value)->first();
    }

    /**
     * Returns the logged in user. Typically used across all of my plugins
     * @return null
     */
    public static function getLoggedInUser()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        $user->touchLastSeen();

        return $user;
    }

    /**
     * Redirect a user if they aren't logged in.
     * DO NOT USE. CURRENTLY BROKEN.
     * @param string $url
     * @return mixed
     */
    public static function redirectIfNotLoggedIn($url = '/')
    {
        if(!self::getLoggedInUser())
            return Redirect::to($url);
    }

    /**
     * Returns a Timezone model for the current logged in user
     * @return mixed|null|string
     */
    public static function getLoggedInUsersTimezone()
    {
        $user = self::getLoggedInUser();

        if($user != null)
        {
            $user = self::castToUserExtendedUser($user);
            return $user->timezone;
        }

        return null;
    }

    /**
     * Get a users current timezone.
     * @param $value
     * @param string $property
     * @return null
     */
    public static function getUserTimezone($value, $property = "id")
    {
        $user = self::getUser($value, $property);

        if($user != null)
        {
            return $user->timezone;
        }
        return null;
    }

    /**
     * Casts the Rainlab.User model to Clake.UserExtended
     * @param UserExtended $user
     * @return User
     */
    public static function castToRainLabUser(UserExtended $user)
    {
        $rainlab = new User();
        $rainlab->attributes = $user->attributes;
        return $rainlab;
    }

    /**
     * Casts the Clake.UserExtended model to Rainlab.User
     * Faster than converting, but less thorough
     * @param User $user
     * @return UserExtended
     */
    public static function castToUserExtendedUser($user)
    {
        if($user == null)
            return $user;
        $userExtended = new UserExtended();
        $userExtended->attributes = $user->attributes;
        return $userExtended;
    }

    /**
     * Convert a RainLab.User object to a UserExtended User object
     * Slower than casting, but more thorough
     * @param $user
     * @return mixed
     */
    public static function convertToUserExtendedUser($user)
    {
        if($user == null)
            return $user;
        $id = $user->id;
        return UserExtended::where('id', $id)->first();
    }

    /**
     * Search for a user via the phrase
     * @param $phrase
     * @return mixed
     */
    public static function searchUsers($phrase)
    {
        $results = new UserExtended();

        return $results->search($phrase);
    }

    /**
     * @param null $userId
     * @return null
     */
    public static function getUsersIdElseLoggedInUsersId($userId = null)
    {
        if($userId == null)
            $userId = UserUtil::getLoggedInUser();

        if($userId == null)
            return null;

        return $userId->id;
    }

    /**
     * Returns the UserExtended object for the user ID passed in. If the user ID passed in is null,
     * gets logged in user.
     * @param null $userId
     * @return mixed|null
     */
    public static function getUserForUserId($userId = null)
    {
        $id = self::getUsersIdElseLoggedInUsersId($userId);

        if($id == null)
            return null;

        return self::getUser($id);
    }

    /**
     * @param $userId
     * @return bool|void
     */
    public static function idIsLoggedIn($userId)
    {
        $user = self::getLoggedInUser();
        if($user == null)
            return;
        return $user->id == $userId;
    }

    /**
     * Gets the logged in user object and converts it to an UserExtended user object before returning it
     * @return mixed
     */
    public static function getLoggedInUserExtendedUser()
    {
        return self::convertToUserExtendedUser(self::getLoggedInUser());
    }

}