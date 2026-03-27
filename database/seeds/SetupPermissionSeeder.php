<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SetupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::whereNotIn('id', [1])->delete();
    }
}
