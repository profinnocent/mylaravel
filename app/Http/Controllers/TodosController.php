<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;

use App\Models\Todos;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['Tods'=> Todos::all(),
                                'status'=>true], 200);
    }

    
    public function store(Request $request)
    {
        // print_r($request->all);
        // Get the logged in user id
        $user = $request->user();

        // return $user->id;

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
    public function show($id)
    {
        $todo = Todos::find($id);
        if($todo) 
        return response()->json(['todo'=>$todo, 'status'=>true], 201);

        return response()->json(['message'=>'todo not found',
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

            if($todo->update($request->all())){
                return response(['message'=> 'Todo updated successfully.', 'statuscode' => 201]);
            }

            return response(['message'=> 'Failed to update Todo.', 'statuscode' => 401]);
        }

        return response(['message'=> 'Todo not found', 'statuscode' => 401]);
    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return Todos::destroy($id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {

        return Todos::where('task', 'like', '%'. $name . '%')->get();

    }
}
