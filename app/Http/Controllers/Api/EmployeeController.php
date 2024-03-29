<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employee\StoreEmployeeRequest;
use App\Http\Requests\Api\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::query()->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->safe()->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employee/photo', 'public');
        }

        $employee = Employee::query()->create($data);

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->except(['_token', '_method', 'photo']);

        if ($request->hasFile('photo')) {
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }

            $data = $request->file('photo')->store('employee/photo', 'public');
        }

        $employee->update($data);

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return response()->noContent();
    }

    public function getEmployeeByTeam(Request $request)
    {
        $teamId = $request->team_id;

        if ($teamId) {
            $employees = Team::query()->findOrFail($teamId)->employees;

            return EmployeeResource::collection($employees);
        }

        return response()->json(['message' => 'Employee not found.'], 404);
    }

    public function getEmployeeByRole(Request $request)
    {
        $roleId = $request->role_id;

        if ($roleId) {
            $employees = Role::query()->findOrFail($roleId)->employees;

            return EmployeeResource::collection($employees);
        }

        return response()->json(['message' => 'Employee not found.'], 404);
    }
}
