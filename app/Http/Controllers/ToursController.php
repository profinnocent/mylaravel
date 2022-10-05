<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tours;


class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tours::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request inputs
        $data = $request->validate([
            'destination' => 'required|string|max:100',
        'slug' => 'required|string|max:100',
        'tour_code' => 'required|string|max:50',
        'description' => 'required|string',
        'city' => 'required|string|max:50',
       'country' => 'required|string|max:50',
        'price' => 'required|decimal',
        'visits' => 'required|integer',
        'rating' => 'required|decimal'
        ]);

        // Create and return new tour destination
        return Tours::create([
            'destination' => $data['destination'],
        'slug' => $data['slug'],
        'tour_code' => $data['tour_code'],
        'description' => $data['description'],
        'city' => $data['city'],
       'country' => $data['country'],
        'price' => $data['price'],
        'visits' => $data['visits'],
        'rating' => $data['ratings']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Tours::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $tour = Tours::find($id);

        if($tour){

            $tour = $tour->update($request->all());
            return response(['tour'=>$tour, 'message'=>'Todo with this id not found', 'statuscode' => 201]);

        }else{

            return response(['message'=>'Todo with this id not found', 'statuscode' => 401]);
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tours::destroy($id);
    }


     /**
     * Display the specified resource based on name.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Tours::where('destination', 'like', '%' . $name . '%')->get();
    }
}
