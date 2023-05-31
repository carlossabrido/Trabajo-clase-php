<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class TaskController extends Controller
{
    public function getTask (Request $request){

        try {
            $userId = $request->input('user_id');
            $tasks = Task::query()->where('user_id','=', $userId)->get();

            // dd($userId);

            return response()->json([
                "success" => true,
                "message" => 'Task retrieved successfully',
                'data' => $tasks
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot retrieve task',
                'error' => $th->getMessage()
            ]);
        }
    }


    public function createTask(Request $request)
    {
        try {
            $title = $request->input('title');
            $description = $request->input('description');
            $userId = $request->input('user_id');
    
            // insert using query builder 
            // DB::table('tasks')->insert([
            //     'title' => $title,
            //     'description' => $description,
            //     'user_id' => $userId
            // ]);

            // inster with Eloquent

            $task= new Task();
            $task->title =$title;
            $task->description = $request->input('description');
            $task->user_id= $userId;
            $task->save();



    
            return response()->json([
                "success" => true,
                "message" => 'Create task successfully',
                'data' => []
            ]) ;
        } catch (\Throwable $th) {
            return response()->json( [
                'success' => false,
                'message' => 'Create task went wrong',
                'error' => $th->getMessage()
            ],
            418) ;
        }
    }

    public function updateTaskById($id,Request $request){
        try{


            $data=[
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'user_id' => $request->input('user_id')
            ];

            $task = DB::table('tasks')
              ->where('id','=',$id)
              ->update($data);


        return [

            "succes"=> true,
            "message"=>'modify task succesfully with id:'.$id,
            'data'=>$task
    
        ];
    }catch(\Throwable $th){
        return response()->json( [
            'success' => false,
            'message' => 'modified task went wrong',
            'error' => $th->getMessage()
        ],
        418);
    };
    }
    
    public function deleteTaskById($id){

        try{

            $deleted = DB::table('tasks')->where('id','=',$id)->delete();

        return [

            "succes"=> true,
            "message"=>'delete task succesfully with id:'.$id,
            'data'=>$deleted
    
        ];
    }catch(\Throwable $th){
        return response()->json( [
            'success' => false,
            'message' => 'deleted task went wrong',
            'error' => $th->getMessage()
        ],
        418);
    };
    }



}
