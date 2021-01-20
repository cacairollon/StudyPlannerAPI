<?php

namespace App\Http\Controllers;

use App\Models\Task;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    private $guard = 'api';


    public function __construct()
    {
        $this->middleware('jwt-check');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return DB::table('tasks')
            ->select('id', 'title', 'description')
            ->paginate(50);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $err = array(
                'title' => $errors->first('title'),
                'description' => $errors->first('description'),
            );

            return response()->json(array(
                'message' => 'Cannot process request',
                'errors' => $err
            ), 422);
        }

        $task = new Task;
        $task->title = $request->input("title");
        $task->description = $request->input("description");
        $task->save();

        return response()->json(array(
            "message" => "Task created Successful",
            "task" => $task
        ), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if ($task == NULL) {
            return response()->json(array(
                "message" => "Task not found!",
            ), 404);
        }

        return response()->json(array($task), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $task = Task::find($id);
        if ($task == NULL) {
            return response()->json(array(
                "message" => "Task not found!",
            ), 404);
        }

        if ($request->has('title'))
            $task->title = $request->input('title');
        if ($request->has('description'))
            $task->description = $request->input('description');
        $task->save();

        return response()->json(array(
            "message" => "Task is updated!",
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task == NULL) {
            return response()->json(array(
                "message" => "Task not found!",
            ), 404);
        }

        $task->delete();

        return response()->json(array(
            "message" => "Task is deleted!",
        ));
    }
}
