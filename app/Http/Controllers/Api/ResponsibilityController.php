<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Responsibility\StoreResponsibilityRequest;
use App\Http\Requests\Api\Responsibility\UpdateResponsibilityRequest;
use App\Http\Resources\ResponsibilityResource;
use App\Models\Responsibility;
use App\Models\Role;
use Illuminate\Http\Request;

class ResponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResponsibilityResource::collection(Responsibility::query()->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResponsibilityRequest $request)
    {
        $data = $request->validated();

        $responsibility = Responsibility::query()->create($data);

        return new ResponsibilityResource($responsibility);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function show(Responsibility $responsibility)
    {
        return new ResponsibilityResource($responsibility);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponsibilityRequest $request, Responsibility $responsibility)
    {
        $data = $request->validated();

        $responsibility->update($data);

        return new ResponsibilityResource($responsibility);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responsibility $responsibility)
    {
        $responsibility->delete();

        return response()->noContent();
    }

    public function getResponsibilityByRole(Request $request)
    {
        $roleId = $request->role_id;

        if ($roleId) {
            $responsibilities = Role::query()->findOrFail($roleId)->responsibilities;

            return ResponsibilityResource::collection($responsibilities);
        }

        return response()->json(['Responsibility not found.'], 404);
    }
}
