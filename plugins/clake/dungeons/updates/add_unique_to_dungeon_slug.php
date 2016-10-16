<?php
namespace Clake\Dungeons\Updates;

use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class UsersAddLastSeen extends Migration
{
    public function up()
    {
        Schema::table('clake_dungeons_dungeons', function(Blueprint $table)
        {
            $table->dropColumn('slug');
            $table->string('slug')->unique();
        });
    }

    public function down()
    {
        Schema::table('clake_dungeons_dungeons', function($table)
        {
            $table->dropColumn('slug');
            $table->string("slug");
        });
    }
}
