<?php namespace Clake\UserExtended\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use RainLab\User\Models\UserGroup;

/**
 * User Groups Back-end Controller
 */
class GroupsExtended extends Controller
{
    public $implement = [
        'Backend.Behaviors.ReorderController'
    ];

    public $reorderConfig = 'config_reorder.yaml';

    //public $requiredPermissions = ['rainlab.users.access_groups'];

    public function index()
    {


    }

    public function __construct()
    {
        parent::__construct();

        //BackendMenu::setContext('RainLab.User', 'user', 'usergroups');
    }

}