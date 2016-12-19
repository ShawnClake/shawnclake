<?php

namespace Clake\UserExtended\Classes;

use Clake\Userextended\Models\UserExtended;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use October\Rain\Parse\Yaml;

/**
 * TODO: Cleanup this class
 * TODO: Finish this class
 * TODO: Enforce conventions, SRP, and function usage
 */

/**
 * Class UserSettingsManager
 * @package Clake\UserExtended\Classes
 */
class UserSettingsManager
{

    protected $settingsTemplate = [];
    protected $settings = [];
    protected $user = null;

    private $defaults = [
        'label' => '',
        'type' => 'text',
        'validation' => '',
        'editable' => true,
        'createable' => true,
        'registerable' => true,
        'encrypt' => false,
    ];

    /**
     * Creates an instance of the UserSettingsManager
     * @param UserExtended|null $user
     * @return null|static
     */
    public static function init(UserExtended $user = null)
    {
        $instance = new static;
        $path = plugins_path('clake/userextended/config/user_settings.yaml');
        $settingsTemplate = Yaml::parseFile($path);

        if(isset($settingsTemplate['settings']))
            $instance->settingsTemplate = $settingsTemplate['settings'];
        else
            return null;

        if($user == null)
            $user = UserUtil::castToUserExtendedUser(UserUtil::getLoggedInUser());

        $instance->user = $user;

        $instance->settings = $instance->user->settings;

        return $instance;
    }

    /**
     * Determines whether the passed string is a valid setting according to the config
     * @param $setting
     * @return bool
     */
    public function isSetting($setting)
    {
        return array_key_exists($setting, $this->settingsTemplate);
    }

    /**
     * Gets the settings options prioritizing config and then defaults
     * @param $setting
     * @return array|void
     */
    public function getSettingOptions($setting)
    {
        if(!$this->isSetting($setting))
            return;

        $options = $this->settingsTemplate[$setting];

        return $this->mergeOptionsWithDefaults($options);
    }

    /**
     * Helper function for merging the config options with defaults
     * @param $options
     * @return array
     */
    public function mergeOptionsWithDefaults($options)
    {
        return array_merge($this->defaults, $options);
    }

    /**
     * Gets the value of a setting on a user model
     * @param $setting
     * @return mixed|string
     */
    public function getSettingValue($setting)
    {
        $value = '';

        if(isset($this->settings[$setting]))
            $value = $this->settings[$setting];

        return $value;
    }

    /**
     * Returns an array in the form of [value, options=>[]] for a setting on a user model
     * @param $setting
     * @return array|null
     */
    public function getSetting($setting)
    {
        if(!$this->isSetting($setting))
            return null;

        $value = $this->getSettingValue($setting);

        $value = $this->decrypt($setting, $value);

        $options = $this->getSettingOptions($setting);

        return [$value, 'options' => $options];
    }

    /**
     * Returns an array in the form of [setting1=>[value. options=>[]], setting2=>[value. options=>[]]]
     * representing all of the settings on a user model
     * @return array
     */
    public function all()
    {
        $settings = [];

        foreach($this->settingsTemplate as $setting)
        {
            $options = $this->getSettingOptions($setting);

            $value = '';

            if(isset($this->settings[$setting]))
                $value = $this->settings[$setting];

            $settings[$setting] = [$value, 'options' => $options];
        }

        return $settings;
    }

    /**
     * Returns whether or not a setting is read only or editable
     * @param $setting
     * @return bool
     */
    public function isEditable($setting)
    {
        $options = $this->getSettingOptions($setting);
        return $options['editable'] && $options['editable'] != 'false';
    }

    /**
     * Returns whether or not a setting has validation rules
     * @param $setting
     * @return bool
     */
    public function isValidated($setting)
    {
        $options = $this->getSettingOptions($setting);
        return $options['validation'] != '';
    }

    /**
     * Returns whether or not a setting should be encrypted
     * @param $setting
     * @return bool
     */
    public function isEncrypted($setting)
    {
        $options = $this->getSettingOptions($setting);
        return $options['encrypt'] && $options['encrypt'] != 'false';
    }

    /**
     * Returns whether or not a passed value passes its validation rules
     * Will return true if the setting does not require validation
     * @param $setting
     * @param $value
     * @return bool
     */
    public function validate($setting, $value)
    {
        $options = $this->getSettingOptions($setting);

        if($this->isValidated($setting))
        {
            $validator = Validator::make(
                ['setting' => $value],
                ['setting' => $options['validation']]
            );

            if($validator->fails())
                return false;
        }

        return true;
    }

    /**
     * Returns an encrypted version of the passed value.
     * It will return the NON encrypted value if encryption is not required for the setting
     * @param $setting
     * @param $value
     * @return mixed
     */
    public function encrypt($setting, $value)
    {
        if($this->isEncrypted($setting))
        {
            $value = Crypt::encrypt($value);
        }

        return $value;
    }

    /**
     * Returns th decrypted version of the passed value
     * It will return the value if encryption is not required
     * @param $setting
     * @param $value
     * @return mixed
     */
    public function decrypt($setting, $value)
    {
        if($this->isEncrypted($setting))
        {
            $value = Crypt::decrypt($value);
        }

        return $value;
    }

    /**
     * Sets a setting by checking whether or not it can be edited, then validates it, then encrypts it if requried.
     * @param $setting
     * @param $value
     * @return $this|bool
     */
    public function setSetting($setting, $value)
    {
        if(!($this->isEditable($setting)))
            return false;

        if(!$this->validate($setting, $value))
            return false;

        $value = $this->encrypt($setting, $value);

        $this->settings[$setting] = $value;

        return $this;
    }

    /**
     * Save the settings to the user model
     * @return $this
     */
    public function save()
    {
        $this->user->settings = $this->settings;
        $this->user->save();
        return $this;
    }






}