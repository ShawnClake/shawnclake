<?php
namespace Clake\Dungeons\Updates;

use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class AddUniqueToDungeonSlug extends Migration
{
    public function up()
    {
        Schema::table('clake_dungeons_dungeons', function(Blueprint $table)
        {
            $table->string('slug')->unique()->change();;
        });
    }

    public function down()
    {
        Schema::table('clake_dungeons_dungeons', function($table)
        {
            $table->string("slug")->change();;
        });
    }
}
