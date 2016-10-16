<?php namespace Clake\Pusher;

use Backend;
use System\Classes\PluginBase;

/**
 * pusher Plugin Information File
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
            'name'        => 'Pusher',
            'description' => 'Pusher plugin for OctoberCMS',
            'author'      => 'clake',
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
            'Clake\Pusher\Components\AuthEndpoint' => 'authEndpoint',
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
            'clake.pusher.some_permission' => [
                'tab' => 'pusher',
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
            'pusher' => [
                'label'       => 'pusher',
                'url'         => Backend::url('clake/pusher/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['clake.pusher.*'],
                'order'       => 500,
            ],
        ];
    }

}
