<?php namespace Clake\Userextended\Models;

use Model;
use RainLab\User\Models\UserGroup;
use October\Rain\Database\Traits\Sortable;

/**
 * UserExtended Model
 */
class GroupsExtended extends UserGroup
{

    use Sortable;

    /**
     * Used to manually add relations for the user table
     * UserExtended constructor.
     */
    public function __construct()
    {


        parent::__construct();
    }

}