<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use App\Events\NewEmployee;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EmployeesDataTable $categoriesDataTable
     * @return Application|Factory|View
     */
    public function index(EmployeesDataTable $employeesDataTable)
    {
        $companies = Company::all()->pluck("name", "id");
        return $employeesDataTable->render('components.employee.index', compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();
        $companies = Company::all()->pluck('name', 'id');
        return view('components.employee.create', compact('employee', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:6',
            'company_id' => 'required|exists:companies,id',
            'photos' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }

        $inputs['image_id'] = json_decode($inputs['photos'])[0];
        unset($inputs['photos']);

        $employee = Employee::create($inputs);

        event(new NewEmployee($employee));

        return redirect()->route('employees.index')->with(['success' => 'Employee ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('components.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all()->pluck('name', 'id');
        $employee->image_id = Upload::find($employee->image_id);
        return view('components.employee.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'password' => 'required|string|min:6',
            'company_id' => 'required|exists:companies,id',
            'photos' => 'sometimes'
        ]);
        if ($validator->fails()) {
            return redirect()->route('employees.edit', $employee)->withErrors($validator)->withInput();
        }
        if (isset($inputs['photos'])) {
            $inputs['logo_id'] = json_decode($inputs['photos'])[0];
            unset($inputs['photos']);
        }
        $employee->update($inputs);
        return redirect()->route('employees.index')->with(['success' => 'Employee ' . __("messages.edit")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with(['success' => 'Employee ' . __("messages.delete")]);
    }
}
