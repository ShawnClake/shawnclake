<?php

namespace Clake\UserExtended\Classes;

use Auth;
use Carbon\Carbon;
use Clake\Userextended\Models\Timezone;
use Clake\Userextended\Models\UserExtended;
use RainLab\User\Models\User;
use Redirect;

/**
 * Class UserUtil
 * @package Clake\UserExtended\Classes
 *
 * @todo: Move time related methods to a seperate trait
 * @todo: Test casting and timezones
 *
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
     * Redirect a user if they aren't logged in. CURRENTLY BROKEN.
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
        $user = self::castToUserExtendedUser($user);
        if($user != null)
            return $user->timezone;
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
            return $user->timezone;
        return null;
    }

    /**
     * Adjust the current UTC time by minutes, hours, days, and seconds
     * @param $minutes
     * @param int $hours
     * @param int $days
     * @param int $seconds
     * @return Carbon
     */
    public static function getCurrentTimeAdjusted($minutes, $hours = 0, $days = 0, $seconds = 0)
    {
        $current = Carbon::now();
        $current->addHours($hours);
        $current->addMinutes($minutes);
        $current->addDays($days);
        $current->addSeconds($seconds);
        return $current;
    }

    /**
     * Take a time string such as 2:30 or 4:00 and convert it into minutes and hours
     * @param $time
     * @return array
     */
    private static function getTimeStringAdjustments($time)
    {
        $time = explode(":", $time);
        $minutes = 0;
        $hours = $time[0];
        if(isset($time[1]))
            $minutes = $time[1];
        return [
            'minutes' => $minutes,
            'hours' => $hours,
        ];
    }

    /**
     * Get the current time adjusted via the logged in Users timezone
     * @return Carbon
     */
    public static function getLoggedInUsersCurrentTimeAdjusted()
    {
        $offset = self::getLoggedInUsersTimezone()->offset;
        $adjustment = self::getTimeStringAdjustments($offset);
        return self::getCurrentTimeAdjusted($adjustment['minutes'], $adjustment['hours']);
    }

    /**
     * Gets the current time adjusted via a Users timezone
     * @param UserExtended $user
     * @return Carbon
     */
    public static function getUsersCurrentTimeAdjusted(UserExtended $user)
    {
        $offset = $user->timezone->offset;
        $adjustment = self::getTimeStringAdjustments($offset);
        return self::getCurrentTimeAdjusted($adjustment['minutes'], $adjustment['hours']);
    }

    /**
     * Gets a time adjusted via a Timezone model.
     * @param $time
     * @param Timezone $timezone
     * @return mixed
     */
    public static function getTimeAdjustedByTimezone($time, Timezone $timezone)
    {
        $offset = $timezone->offset;
        $adjustment = self::getTimeStringAdjustments($offset);
        return self::getTimeAdjusted($time, $adjustment['minutes'], $adjustment['hours']);
    }

    /**
     * Adjusts an arbitrary time by minutes, hours, days, and seconds
     * @param $time
     * @param $minutes
     * @param int $hours
     * @param int $days
     * @param int $seconds
     * @return mixed
     */
    public static function getTimeAdjusted($time, $minutes, $hours = 0, $days = 0, $seconds = 0)
    {
        $time->addHours($hours);
        $time->addMinutes($minutes);
        $time->addDays($days);
        $time->addSeconds($seconds);
        return $time;
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
     * @param User $user
     * @return UserExtended
     */
    public static function castToUserExtendedUser(User $user)
    {
        $userExtended = new UserExtended();
        $userExtended->attributes = $user->attributes;
        return $userExtended;
    }


}