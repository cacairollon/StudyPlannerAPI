<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
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
        return DB::table('todos')
            ->select('id', 'task_id', 'title', 'isDone')
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
            'task_id' => 'required',
            'title' => 'required',
            'isDone' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $err = array(
                'task_id' => $errors->first('task_id'),
                'title' => $errors->first('title'),
                'isDone' => $errors->first('isDone'),
            );

            return response()->json(array(
                'message' => 'Cannot process request',
                'errors' => $err
            ), 422);
        }

        $todo = new Todo;
        $todo->task_id = $request->input("task_id");
        $todo->title = $request->input("title");
        $todo->isDone = $request->input("isDone");
        $todo->save();

        return response()->json(array(
            "message" => "Todo created Successful",
            "todo" => $todo
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
        $todo = Todo::find($id);
        if ($todo == NULL) {
            return response()->json(array(
                "message" => "Todo not found!",
            ), 404);
        }

        return response()->json(array($todo), 200);
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

        $todo = Todo::find($id);
        if ($todo == NULL) {
            return response()->json(array(
                "message" => "Todo not found!",
            ), 404);
        }

        if ($request->has('task_id'))
            $todo->task_id = $request->input('task_id');
        if ($request->has('title'))
            $todo->title = $request->input('title');
        if ($request->has('isDone'))
            $todo->isDone = $request->input('isDone');
        $todo->save();

        return response()->json(array(
            "message" => "Todo is updated!",
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
        $todo = Todo::find($id);
        if ($todo == NULL) {
            return response()->json(array(
                "message" => "Todo not found!",
            ), 404);
        }

        $todo->delete();

        return response()->json(array(
            "message" => "Todo is deleted!",
        ));
    }
}
