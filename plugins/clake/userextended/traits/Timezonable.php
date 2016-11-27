<?php

namespace Clake\UserExtended\Traits;


use Carbon\Carbon;
use Clake\UserExtended\Classes\UserUtil;
use Clake\Userextended\Models\UserExtended;
use Exception;

trait Timezonable
{

    public function getTime($timestamp, UserExtended $user = null)
    {

        if ($user == null)
            $timezone = UserUtil::getLoggedInUsersTimezone();
        else
            $timezone = UserUtil::getUserTimezone($user->id);

        if($timezone == null)
            $timezone = UserUtil::getUTCTimezone();

        $timestamp = new Carbon($timestamp);

        return UserUtil::getTimeAdjustedByTimezone($timestamp, $timezone);

    }

    public function timezonify($timestamp)
    {
        return $this->getTime($timestamp);
    }
    public static function bootTimezonable()
    {
        if (!property_exists(get_called_class(), 'timezonable')) {
            throw new Exception(sprintf(
                'You must define a $timezonable property in %s to use the Timezonable trait.', get_called_class()
            ));
        }

        /*
         * Timezone required fields when necessary
         */
        static::extend(function($model) {
            $timezonable = $model->getTimezonableAttributes();
            $model->bindEvent('model.beforeGetAttribute', function($key) use ($model, $timezonable) {
                if (in_array($key, $timezonable) && array_get($model->attributes, $key) != null) {
                    return $model->timezonify($model->attributes[$key]);
                }
            });
        });
    }

    /**
     * Returns a collection of fields that will be encrypted.
     * @return array
     */
    public function getTimezonableAttributes()
    {
        return $this->timezonable;
    }



}