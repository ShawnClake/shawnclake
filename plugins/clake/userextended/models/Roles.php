<?php namespace Clake\Userextended\Models;

use Model;
use October\Rain\Database\Traits\Sortable;

/**
 * Roles Model
 */
class Roles extends Model
{
    use Sortable;

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

}