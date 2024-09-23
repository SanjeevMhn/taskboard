<?php

namespace Database\Seeders;

use App\Models\TaskCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_categories')->delete();
        $categories = [
            [
                'name' => 'TO DO',
            ],
            [
                'name' => 'IN PROGRESS'
            ],
            [
                'name' => 'IN REVIEW'
            ],
            [
                'name' => 'DONE'
            ]
        ];
        DB::table('task_categories')->insert($categories);
    }
}
