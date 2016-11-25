<?php namespace Clake\UserExtended;

use Backend\Classes\Controller;
use System\Classes\PluginBase;
use Event;
use Backend;
/**
 * UserExtended Plugin Information File
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
            'name'        => 'UserExtended',
            'description' => 'Adds roles, friends, and utility functions to the Rainlab User plugin',
            'author'      => 'clake',
            'icon'        => 'icon-user-plus'
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

        Event::listen('backend.menu.extendItems', function($manager) {

            $manager->addSideMenuItems('RainLab.User', 'user', [
                'groups' => [
                    'label' => 'Group Manager',
                    'url'         => Backend::url('clake/userextended/groupsextended'),
                    'icon'        => 'icon-user',
                    'order'       => 500,
                ]
            ]);

        });

        /*Controller::extend(function($controller){

            if(!$controller instanceof \RainLab\User\Controllers\UserGroups)
                return;

            $controller->reorderConfig = plugins_path('clake/userextended/controllers/groupsextended/config_reorder.yaml');

            $controller->implement[] = 'Backend.Behaviors.ReorderController';

        });*/



        /*Event::listen('backend.form.extendFields', function($widget) {

            // Only for the User controller
            if (!$widget->getController() instanceof \RainLab\User\Controllers\Users) {
                return;
            }

            // Only for the User model
            if (!$widget->model instanceof \RainLab\User\Models\User) {
                return;
            }

            // Add an extra birthday field
            $widget->addFields([
                'birthday' => [
                    'label'   => 'Birthday',
                    'comment' => 'Select the users birthday',
                    'type'    => 'datepicker'
                ]
            ]);

            // Remove a Surname field
            $widget->removeField('surname');
        });*/

        return [];

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
            'Clake\UserExtended\Components\UserGroups' => 'usergroups',
            'Clake\UserExtended\Components\ListFriends' => 'friends',
            'Clake\UserExtended\Components\UserList' => 'userlist',
            'Clake\UserExtended\Components\ListFriendRequests' => 'friendrequests',
            'Clake\UserExtended\Components\UserSearch' => 'usersearch',
            'Clake\UserExtended\Components\UserUI' => 'userui',
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
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate
    }

}
