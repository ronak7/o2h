<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::latest()->paginate(10);
        $title = "Employee list";
        return view('pages.employee.list', compact('title', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $title = "Create employee";
        return view('pages.employee.create', compact('title', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'company_id' => 'required'
        ]);
        try {
            $employee = new Employee();
            $employee->company_id = $request->company_id;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->phone = $request->phone;
            $employee->save();

            return redirect()->route('employee.index')->with('status', 'Employee added successfully.');
        } catch (\Exception $e) {

            echo $e;
            // return redirect()->route('employee.index')->with('status', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $title = "Employee";
        return view('pages.employee.show', compact('title', 'companies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::orderBy('name', 'asc')->get();
        $title = "Edit employee";
        return view('pages.employee.edit', compact('title', 'companies', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'company_id' => 'required'
        ]);
        try {
            $employee->company_id = $request->company_id;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->phone = $request->phone;
            $employee->save();

            return redirect()->route('employee.index')->with('status', 'Employee has been updated successfully.');
        } catch (\Exception $e) {

            echo $e;
            // return redirect()->route('employee.index')->with('status', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('status', 'Employee has been deleted successfully.');
    }
}
