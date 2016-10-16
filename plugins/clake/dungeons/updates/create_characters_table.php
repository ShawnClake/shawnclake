<?php namespace Clake\Dungeons\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCharactersTable extends Migration
{
    public function up()
    {
        Schema::create('clake_dungeons_characters', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('dungeonplayers_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clake_dungeons_characters');
    }
}
