<?php namespace Clake\Dungeons;

use Backend;
use System\Classes\PluginBase;

/**
 * dungeons Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Dungeons',
            'description' => 'Dungeons and dragons',
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
            'Clake\Dungeons\Components\DungeonList' => 'dungeonList',
            'Clake\Dungeons\Components\DungeonLobby' => 'dungeonLobby',
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
            'clake.dungeons.some_permission' => [
                'tab' => 'dungeons',
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
            'dungeons' => [
                'label'       => 'dungeons',
                'url'         => Backend::url('clake/dungeons/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['clake.dungeons.*'],
                'order'       => 500,
            ],
        ];
    }

}
