<?php namespace Clake\UserExtended\Updates;

use RainLab\User\Models\UserGroup;
use October\Rain\Database\Updates\Seeder;

class SeedUserGroupsTable extends Seeder
{
    public function run()
    {
        UserGroup::create([
            'name' => 'Admins',
            'code' => 'admin',
            'description' => 'Administrator group',
        ]);

        UserGroup::create([
            'name' => 'Friends',
            'code' => 'friend',
            'description' => 'Generalized friend group.',
        ]);

        /*UserGroup::create([
            'name' => 'Guest',
            'code' => 'guest',
            'description' => 'Generalized guest group.'
        ]);*/

        UserGroup::create([
            'name' => 'Testers',
            'code' => 'tester',
            'description' => 'Access bleeding edge features',
        ]);

        UserGroup::create([
            'name' => 'Debuggers',
            'code' => 'debugger',
            'description' => 'Debug text, buttons, and visuals appear on the pages',
        ]);

        UserGroup::create([
            'name' => 'Developers',
            'code' => 'developer',
            'description' => 'Access to the dev tools and options',
        ]);

        UserGroup::create([
            'name' => 'Banned',
            'code' => 'banned',
            'description' => 'Banned from viewing pages',
        ]);

        UserGroup::create([
            'name' => 'default',
            'code' => 'default',
            'description' => 'Default group for Users',
        ]);

    }
}
