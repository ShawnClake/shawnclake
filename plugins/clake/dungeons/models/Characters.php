<?php namespace Clake\Dungeons\Models;

use Model;

/**
 * Characters Model
 */
class Characters extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'clake_dungeons_characters';

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
        'dungeonplayer' => ['Clake\Dungeons\Models\DungeonPlayers', 'key' => 'dungeonplayers_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}