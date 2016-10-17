<?php
namespace Clake\Dungeons\Updates;

use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class AddDataToCharactersTable extends Migration
{
    public function up()
    {
        Schema::table('clake_dungeons_characters', function(Blueprint $table)
        {
            $table->string('name');
            $table->string('type');
        });
    }

    public function down()
    {
        Schema::table('clake_dungeons_characters', function($table)
        {

        });
    }
}
