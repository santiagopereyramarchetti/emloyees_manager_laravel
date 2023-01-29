<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeparmentStoreRequest;
use App\Http\Requests\DeparmentUpdateRequest;
use App\Models\Deparment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DeparmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if($request->has('search')){
            $deparments = Deparment::where('name', 'like', "%{$request->search}%")->get();
        }else{
            $deparments = Deparment::all();
        }
        return view('deparments.index', compact('deparments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deparments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeparmentStoreRequest $request)
    {
        Deparment::create([
            'name' => $request->name
        ]);
        
        return Redirect::route('deparments.index')->with('message', 'Deparment Succesfully Created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Deparment $deparment)
    {
        return view('deparments.edit', compact('deparment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeparmentUpdateRequest $request, Deparment $deparment)
    {
        $deparment->update([
            'name' => $request->name
        ]);
        return Redirect::route('deparments.index')->with('message','Deparment Succesfully Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deparment $deparment)
    {   
        $deparment->delete();
        return Redirect::route('deparments.index')->with('message','Deparment Succesfully Deleted');
    }
}
