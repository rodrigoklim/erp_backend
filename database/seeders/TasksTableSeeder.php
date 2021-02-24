<?php

namespace Database\Seeders;

use App\Models\Tasks;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $task = new Tasks;
        $task->user_id       = '1';
        $task->task          = 'outra tarefa pra realizar';
        $task->responsible   = 'Rodrigo';
        $task->status     = '0';
        $task->save();
    }
}
