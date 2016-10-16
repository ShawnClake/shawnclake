<?php namespace Clake\Dungeons\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDungeonsTable extends Migration
{
    public function up()
    {
        Schema::create('clake_dungeons_dungeons', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string("name");
            $table->string("slug");
            $table->text("description");
            $table->smallInteger("visibility");
            $table->integer("dm");
            $table->json("settings");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clake_dungeons_dungeons');
    }
}
