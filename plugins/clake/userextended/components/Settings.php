<?php namespace Clake\UserExtended\Components;

use Clake\UserExtended\Classes\UserSettingsManager;
use Clake\UserExtended\Classes\UserUtil;
use Cms\Classes\ComponentBase;
use Flash;
use Lang;
use Auth;

class Settings extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'User Settings',
            'description' => 'Provides a form for a user to be able to update their settings'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * Copied from the RainLab.Users Account component
     * Altered by Shawn Clake
     */
    public function onUpdate()
    {
        if (!$user = $this->user()) {
            return;
        }

        $values = post();

        $user->name = $values['name'];
        $user->email = $values['email'];

        $user->save();

        $settingsManager = UserSettingsManager::init();

        foreach($values as $key=>$value)
        {
            if($key=="_session_key" || $key=="_token" || $key=="name" || $key=="email" || $key=="password" || $key=="password_confirmation")
                continue;

            if($settingsManager->isSetting($key))
                $settingsManager->setSetting($key, $value);
        }

        $settingsManager->save();

        echo(json_encode($values));

        if (strlen(post('password'))) {
            Auth::login($user->reload(), true);
        }

        Flash::success(post('flash', Lang::get('rainlab.user::lang.account.success_saved')));

    }

    /**
     * @return mixed
     */
    public function user()
    {
        return UserUtil::convertToUserExtendedUser(UserUtil::getLoggedInUser());
    }

    /**
     * @return array
     */
    public function settings()
    {
        return UserSettingsManager::init()->getUpdateable();
    }

}