<?php namespace Clake\Dungeons\Models;

use Model;

/**
 * Dungeons Model
 */
class Dungeons extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'clake_dungeons_dungeons';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    protected $jsonable = [
        "settings"
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'players' => 'Clake\Dungeons\Models\DungeonPlayers'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}