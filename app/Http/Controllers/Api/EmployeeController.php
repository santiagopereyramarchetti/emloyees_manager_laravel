<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeSingleResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search') && $request->missing('deparment_id')){
            $employees = Employee::where('first_name', 'like', "%{$request->search}%")->orWhere('last_name','like',"%{$request->search}%")->get();
        }else if ($request->has('deparment_id') && $request->missing('search')){
            $employees = Employee::where('deparment_id', $request->deparment_id)->get();
        }else if ($request->has('deparment_id') && $request->has('search')){
            $employees = Employee::where('deparment_id', $request->deparment_id)->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%")->get();
        }else{
            $employees = Employee::all();
        }
        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = Employee::create($request->validated());
        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeSingleResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return response()->json('Employee Succesfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json('Employee Succesfully Deleted');
    }
}
