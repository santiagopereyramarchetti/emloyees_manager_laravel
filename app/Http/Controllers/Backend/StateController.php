<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){
            $states = State::where('country_id','like',"%{$request->search}%")->orWhere('name', 'like',"%{$request->search}%")->with('country')->get();
        }else{
            $states = State::with('country')->get();
        }
        return view('states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('states.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateStoreRequest $request)
    {
        State::create([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);
        return Redirect::route('states.index')->with('message','State Succesfully Create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $countries = Country::all();
        return view('states.edit', compact('state', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateUpdateRequest $request, State $state)
    {
        $state->update([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);
        return Redirect::route('states.index')->with('message', 'State Succesfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
        return Redirect::route('states.index')->with('message', 'State Succesfully Delete');
    }
}
