<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('categories') -> insert(array(
            array(
                'id' => 'ID example',
                'name' => 'Name of ID example'
            ),
            array(
                'id' => 'Another ID example',
                'name' => 'Another Name of ID example'
            )
        ));
    }
}
