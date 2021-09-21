<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Requests\Department\MassDestroyDepartmentRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class DepartmentsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('department_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::with('parent')->get();

        return view('admin.departments.index', compact('departments'));
    }
    
    public function create()
    {
        abort_if(Gate::denies('department_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('title', 'id');
        return view('admin.departments.create', compact('departments'));
    }
    
    public function store(StoreDepartmentRequest $request)
    {
        Department::create($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department has been create successfully');
    }
    
    public function show(Department $department)
    {
        //
    }
    
    public function edit(Department $department)
    {
        abort_if(Gate::denies('department_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


    }
    
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        //
    }
    
    public function destroy(Department $department)
    {
        abort_if(Gate::denies('department_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function MassDestroy(MassDestroyDepartmentRequest $department)
    {
        Department::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
