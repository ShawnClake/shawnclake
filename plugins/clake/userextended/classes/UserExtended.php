<?php


namespace Clake\UserExtended\Classes;

/**
 * Class UserExtended
 *
 * UserExtended Modular Control
 *
 * Extend this class to build a module for UserExtended.
 *
 * Usage example: Module Name: clakeForum  Function Call: getUserActivity()
 *      Then the call would look like: UserExtended::clakeForum()->getUserActivity();
 *
 * In order to add your module to the module registry you must create an instance of your extensible class
 * on run inside of your plugin's plugin.php
 *
 * @package Clake\UserExtended\Classes
 */
abstract class UserExtended extends Module
{

    /**
     * The module registry
     * An array of all the registerd modules. This is populated at runtime.
     * @var array
     */
    private static $modules = [];

    /**
     * Component injection registry
     * @var array
     */
    private static $components = [];

    /**
     * Navigation injection registry
     * @var array
     */
    private static $navigation = [];

    /**
     * Lang injection registry
     * @var array
     */
    private static $lang = [];

    /**
     * Override with an array to inject components into UserExtended
     * @return mixed
     */
    public abstract function injectComponents();

    /**
     * Override with an array to inject navigation into UserExtended
     * @return mixed
     */
    public abstract function injectNavigation();

    /**
     * Override with a lang array to inject lang into UserExtended
     * @return mixed
     */
    public abstract function injectLang();

    /**
     * @return array
     */
    public static function getComponents()
    {
        return self::$components;
    }

    /**
     * @return array
     */
    public static function getNavigation()
    {
        return self::$navigation;
    }

    /**
     * @return array
     */
    public static function getLang()
    {
        return self::$lang;
    }

    /**
     * UserExtended constructor.
     */
    public function __construct()
    {
        if(empty($this->name) || empty($this->author) || empty($this->description) || empty($this->version))
            return false;

        $this->register();

        self::$components[] = $this->injectComponents();

        self::$navigation[] = $this->injectNavigation();

        self::$lang[] = $this->injectLang();
    }

    /**
     * Creates a module record for the module registry.
     * The module registry has the format:
     *      [moduleName=>moduleRecord]
     */
    public function register()
    {
        $module = new Module();
        $module->name = $this->name;
        $module->author = $this->author;
        $module->description = $this->description;
        $module->version = $this->version;
        $module->visible = $this->visible;
        $module->instance = $this;
        self::$modules[$this->name] = $module;
    }

    /**
     * Utilize a registered module
     * The call might look like: UserExtended::clakeForum()->getUserActivity();
     * @param $name
     * @param $args
     * @return bool
     */
    public static function __callStatic($name, $args)
    {
        if(!array_key_exists($name, self::$modules))
            return false;

        $module = self::$modules[$name];

        if(!$module->visible)

        return $module->instance;
    }

    /**
     * Returns a loaded module by name
     * Useful for grabbing a specific module for debugging by looking at its values.
     * If you want to run operations on the module, use the static call method instead.
     * @param $moduleName
     * @return bool|mixed
     */
    public function getModule($moduleName)
    {
        if(!array_key_exists($moduleName, self::$modules))
            return false;

        return self::$modules[$moduleName];
    }

    /**
     * Determines whether a module is loaded or not.
     * Useful for debugging
     * @param $moduleName
     * @return bool
     */
    public function isModuleLoaded($moduleName)
    {
        return array_key_exists($moduleName, self::$modules);
    }

    /**
     * Returns the version of a loaded module
     * Useful for ensuring code doesn't break if modules get updated.
     * Also useful if you want to provide multiple versions of the same module.
     * @param $moduleName
     * @return bool
     */
    public function getModuleVersion($moduleName)
    {
        if(!array_key_exists($moduleName, self::$modules))
            return false;

        $module = self::$modules[$moduleName];

        return $module->version;
    }

}

/**
 * Class Module
 * Provides a struct like object for use when loading and using modules
 * @package Clake\UserExtended\Classes
 */
class Module
{

    /**
     * The name of the module
     * Please use the syntax of authorModuleName
     * @var null
     */
    public $name = '';

    /**
     * The full name of the author of the plugin
     * For example: Shawn Clake
     * @var null
     */
    public $author = '';

    /**
     * A brief description of the module's purpose
     * In the case of the forum module the description might be something like:
     *      "Provides user stats and forum content for other plugins to easily utilize"
     * @var null
     */
    public $description = '';

    /**
     * The version the module is running on.
     * For example: 0.0.1
     * @var null
     */
    public $version = '';

    /**
     * Whether or not other modules are able to access your modules extensible class.
     * Typically this should always be true, the only cases where you would want to override this would be
     * if your module doesn't provide any extra functions for other modules to use.
     * @var bool
     */
    public $visible = true;

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }

}