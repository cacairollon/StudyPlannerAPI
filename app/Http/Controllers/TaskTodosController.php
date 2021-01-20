<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskTodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $task = Task::find($id);
        if ($task == NULL) {
            return response()->json(array(
                "message" => "Task not found!",
            ), 404);
        }

        return $task->todos()->get();
    }
}
