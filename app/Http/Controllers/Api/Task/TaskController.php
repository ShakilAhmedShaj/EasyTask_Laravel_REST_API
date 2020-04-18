<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function getAllTask(){

        $user       =   Auth::user();

        $data = DB::table('tasks')->orderBy('id','desc')->where('user_id', $user->id)->get();

        return response()->json($data,200);

    }



    public function store(Request $request){

        $validateData = $request->validate([
            'user_id' =>'required',
            'title' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);

        $data  = new Task();
        $data->user_id = $request->user_id;
        $data->title = $request->title;
        $data->body = $request->body;
        $data->status = $request->status;
        $data->save();

        return response()->json($data,201);

    }

    public function update(Request $request){

        $validateData = $request->validate([
            'id' =>'required',
            'user_id' =>'required',
            'title' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);

        $data  = Task::where('id','=',$request->id)->first();

        $data->user_id = $request->user_id;
        $data->title = $request->title;
        $data->body = $request->body;
        $data->status = $request->status;
        $data->save();

        return response()->json($data,201);

    }

    public function destroy(Request $request){

        $task = Task::where('id','=',$request->id)->first();

        if (!empty($task)){

            if ($task->user_id == $request->user_id){

                $task->delete();

                return response()->json([
                    'success' => 'Your task is deleted successfully.'
                ],200);
            }

            return response()->json([
                'error' => 'Task does not belong to you.'
            ],404);

        }

        return response()->json([
            'error' => 'Task does not exist.'
        ],404);


    }
}
