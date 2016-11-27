<?php namespace Clake\Userextended\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Clake\UserExtended\Classes\GroupManager;
use Clake\UserExtended\Classes\RoleManager;

/**
 * Roles Back-end Controller
 */
class Roles extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';
    //public $layout = 'roles';

    public function __construct()
    {
        parent::__construct();

        //BackendMenu::setContext('Clake.Userextended', 'userextended', 'roles');
        // Setting this context so that our sidebar menu works
        BackendMenu::setContext('RainLab.User', 'user', 'users');
    }

    /**
     * Action used for managing roles such as: their order, some stats, and their properties
     */
    public function manage()
    {
        //dd(RoleManager::initGroupRolesByCode('developer')->get());
        $this->vars['groups'] = GroupManager::all()->get();
        $this->vars['selectedGroup'] = GroupManager::all()->get()->first();

        $groupRoles = RoleManager::initGroupRolesByCode($this->vars['selectedGroup']->code);
        $roleModels = $groupRoles->getSorted();
        if(!isset($roleModels))
            return;
        $this->vars['groupRoles'] = ['roles' => $roleModels, 'roleCount' => $groupRoles->count()];
        //$this->vars['selectedGroup'] = $this->selectedGroupd;
        //return $this->renderRoles($selected);
    }

    /**
     * AJAX handler used when a user clicks on a different group
     * @return array
     */
    public function onSelectGroup()
    {
        $groupCode = post('code');
        $this->vars['selectedGroup'] = GroupManager::retrieve($groupCode);
        return array_merge($this->renderRoles($groupCode), $this->renderToolbar($groupCode), $this->renderGroups($groupCode));
    }

    /**
     * Renders the role list
     * @param $groupCode
     * @return array|void
     */
    public function renderRoles($groupCode)
    {
        $roles = RoleManager::initGroupRolesByCode($groupCode);
        $roleModels = $roles->getSorted();
        if(!isset($roleModels))
            return;
        return [
            '#roles' => $this->makePartial('list_roles', ['roles' => $roleModels, 'roleCount' => $roles->count()]),
        ];
    }

    /**
     * Renders the role management toolbar
     * @param $groupCode
     * @return array|void
     */
    public function renderToolbar($groupCode)
    {
        $group = GroupManager::retrieve($groupCode);
        if(!isset($group))
            return;
        return [
            '#management_toolbar' => $this->makePartial('management_toolbar', ['group' => $group]),
        ];
    }

    /**
     * Renders the group list w/ buttons
     * @param $groupCode
     * @return array|void
     */
    public function renderGroups($groupCode)
    {
        $groups = GroupManager::all()->get();
        $selectedGroup = GroupManager::retrieve($groupCode);
        if(!isset($groups))
            return;
        return [
            '#groups' => $this->makePartial('list_groups', ['groups' => $groups, 'selectedGroup' => $selectedGroup]),
        ];
    }

    /**
     * AJAX handler called when trying to move a role higher in the heirarchy
     * @return array|void
     */
    public function onMoveUp()
    {
        $groupCode = post('groupCode');
        $roleSortOrder = post('order');
        RoleManager::initGroupRolesByCode($groupCode)->sortUp($roleSortOrder);
        return $this->renderRoles($groupCode);
    }

    /**
     * AJAX handler called when trying to move a role lower in the heirarchy
     * @return array|void
     */
    public function onMoveDown()
    {
        $groupCode = post('groupCode');
        $roleSortOrder = post('order');
        RoleManager::initGroupRolesByCode($groupCode)->sortDown($roleSortOrder);
        return $this->renderRoles($groupCode);
    }
}