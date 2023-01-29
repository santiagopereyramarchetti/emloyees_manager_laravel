<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){
            $cities = City::where('state_id','like',"%{$request->search}%")->orWhere('name', 'like',"%{$request->search}%")->with('state')->get();
        }else{
            $cities = City::with('state')->get();
        }
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return view('cities.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        City::create([
            'name' => $request->name,
            'state_id' => $request->state_id
        ]);
        return Redirect::route('cities.index')->with('message','City Succesfully Create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $states = State::all();
        return view('cities.edit', compact('states', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update([
            'name' => $request->name,
            'state_id' => $request->state_id
        ]);
        return Redirect::route('cities.index')->with('message', 'City Succesfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return Redirect::route('cities.index')->with('message', 'City Succesfully Delete');
    }
}
