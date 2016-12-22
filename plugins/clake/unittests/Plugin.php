<?php namespace Clake\UnitTests;

use Backend;
use System\Classes\PluginBase;

/**
 * UnitTests Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Unit Tests',
            'description' => 'Convenient Unit Testing for all your other plugins',
            'author'      => 'Clake',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        //return []; // Remove this line to activate

        return [
            'Clake\UnitTests\Components\Controller' => 'unittests',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'clake.unittests.some_permission' => [
                'tab' => 'UnitTests',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'unittests' => [
                'label'       => 'UnitTests',
                'url'         => Backend::url('clake/unittests/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['clake.unittests.*'],
                'order'       => 500,
            ],
        ];
    }

}
