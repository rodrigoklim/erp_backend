<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function newTask(Request $request)
    {
        
        $user = User::find($request->user);
        
        $task = new Tasks;
        $task->user_id      = $user->id;
        $task->task         = $request->task;
        $task->responsible  = $user->name;
        $task->status       = '0';
        $task->save();


        $tasks = Tasks::where('user_id', $task->user_id)->where('status', 0)->get();

        $response = [
            'msg'       => 'created',
            'tasks'   => $tasks,
        ];

        return $response;
    }

    public function showTasks(Request $request)
    {
        
        $user = User::find($request->user);
        
        $tasks = Tasks::where('user_id', $user->id )->where('status', 0)->get();
        
        return $tasks;
    }

    public function endTask(Request $request)
    {
        $task = Tasks::find($request->id);
        $task->status = 1;
        $task->save();

        $tasks = Tasks::where('user_id', $task->user_id)->where('status', 0)->get();
        
        $response = [
            'msg'     => 'done',
            'tasks'   => $tasks,
        ];

        return $response;
    }
}
