<?php namespace Clake\Userextended\Models;

use Clake\UserExtended\Classes\GroupManager;
use Clake\UserExtended\Classes\RoleManager;
use Model;
use October\Rain\Support\Collection;

//use October\Rain\Database\Traits\Sortable;

/**
 * Roles Model
 */
class Roles extends Model
{
    //use Sortable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'clake_userextended_roles';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'group' => [
            'Clake\UserExtended\Models\GroupsExtended',
            'key' => 'group_id',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function beforeCreate()
    {
        $this->sort_order = RoleManager::initGroupRolesByCode($this->group->code)->count() + 1;
    }

    public function beforeUpdate()
    {
        $total = RoleManager::initGroupRolesByCode($this->group->code)->count();

        if(!(($this->sort_order <= $total) && ($this->sort_order > 0)))
        {
            return false;
        }
    }

}