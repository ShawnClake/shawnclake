<?php namespace Clake\Userextended\Models;

use Model;
use \October\Rain\Database\Traits\Encryptable;

/**
 * Comments Model
 */
class Comments extends Model
{

    use Encryptable;

    protected $encryptable = ['content'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'clake_userextended_comments';

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
        'user' => ['Clake\Userextended\Models\UserExtended', 'key' => 'user_id'],
        'author' => ['Clake\Userextended\Models\UserExtended', 'key' => 'author_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}