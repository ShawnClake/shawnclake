<?php namespace Clake\Dungeons\Models;

use Model;

/**
 * DungeonPlayers Model
 */
class DungeonPlayers extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'clake_dungeons_dungeon_players';

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
    public $hasOne = [
        'character' => ['Clake\Dungeons\Models\Characters', 'key' => 'dungeonplayers_id'],
    ];
    public $hasMany = [];
    public $belongsTo = [
        'user' => 'Rainlab\User\Models\User'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}