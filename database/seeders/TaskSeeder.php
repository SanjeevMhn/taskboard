<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->delete();
        $tasks = [
            [
                'name'        => 'Cannot login as an admin',
                'description' => 'Cannot seem to login as a an admin',
                'category'    => 2
            ],
            [
                'name'        => 'Text hidden by overflow',
                'description' => 'Text seems to be hidden when it is longer please add scrollbar',
                'category'    => 4
            ],
            [
                'name'        => 'Modal not showing form',
                'descrption'  => null,
                'category'    => 3
            ],
            [
                'name'        => 'Make the headin text bigger',
                'descrption'  => null,
                'category'    => 2
            ],
        ];

        DB::table('tasks')->insert($tasks);
    }
}
