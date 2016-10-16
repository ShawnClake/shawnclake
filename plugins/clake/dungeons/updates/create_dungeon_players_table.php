<?php namespace Clake\Dungeons\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDungeonPlayersTable extends Migration
{
    public function up()
    {
        Schema::create('clake_dungeons_dungeon_players', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('dungeons_id');
            $table->integer('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clake_dungeons_dungeon_players');
    }
}
