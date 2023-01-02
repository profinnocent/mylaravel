<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\Todos;

class UserTodosController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $user = $request->user();

        $cur_userid = $user->id;

        $todos = Todos::where('userid', $cur_userid)->get();

        // return $todos;

        // $todos = Todos::all();

        // $todos1 = [];

        // foreach ($todos as $todo) {
        //     if($todo['userid'] == $cur_userid){
        //         array_push($todos1, $todo);
        //     }
        // }

        // $num = count($todos1);

        $todos2 = count($todos) > 0 ? $todos : "You dont have any Todos. Create some.";

        return response()->json(['todos'=> $todos2,
                                 'user'=> $user->id,
                                 'status'=>true], 200);

    }

    
    public function store(Request $request) {

        // Get the logged in user id
        $user = $request->user();

        $validated = $request->validate(['task'=>'required|string',
                                          'status'=>'required']);

        $newTodo = Todos::create([ 'userid' => $user->id,
                                    'task' => $validated['task'],
                                    'status' => $validated['status']]);
                                    
        if($newTodo)

        return response(['message'=>'New Todo created successfully',
                        'todos'=>$newTodo, 
                        'statuscode'=>200]);

        return response(['message'=>'Failed to create New Todo. Try again.',
                        'statuscode'=>400]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $todo = Todos::find($id);

        if($todo){

            $user = $request->user();
            $cur_userid = $user->id;

            if($todo['userid'] == $cur_userid){
                return response()->json(['todo'=>$todo, 'userid'=>$cur_userid, 'status'=>true], 201);
            }

        }

        return response()->json(['message'=>'You dont have any Todo with this ID.',
        'status'=>false], 400);

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

        $todo = Todos::find($id);

        if($todo){

            $user = $request->user();

            if($todo['userid'] == $user->id){

                if($todo->update($request->all())){
                    return response(['message'=> 'Todo updated successfully.', 'statuscode' => 201]);
                }

                return response(['message'=> 'Failed to update Todo. Try again!', 'statuscode' => 401]);
            }
        }

        return response(['message'=> 'You dont have any Todo with this ID', 'statuscode' => 401]);
    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $todo = Todos::find($id);

        if($todo){

            $user = $request->user();

            if($todo['userid'] == $user->id){

                if(Todos::destroy($id)){
                    return response(['message'=> 'Todo deleted successfully.', 'statuscode' => 201]);
                }

                return response(['message'=> 'Failed to delete Todo. Try again!', 'statuscode' => 401]);
            }
        }

        return response(['message'=> 'You dont have any Todo with this ID', 'statuscode' => 401]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $name)
    {

        $todos = Todos::where('task', 'like', '%'. $name . '%')->get();

        $user = $request->user();

        $todos1 = [];

        foreach ($todos as $todo) {
            if($todo['userid'] == $user->id){
                array_push($todos1, $todo);
            }
        }

        $num = count($todos1);

        $todos2 = $num > 0 ? $todos1 : "No matching todos found";

        return response()->json(['todos'=> $todos2,
        'user'=> $user->id,
        'status'=>true], 200);


    }

}
