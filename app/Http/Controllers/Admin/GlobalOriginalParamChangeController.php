<?php

namespace App\Http\Controllers\Admin;

use App\Enums\GlobalOriginalParamChange\GlobalOriginalParamChangeEnumFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GlobalOriginalParamChange\StoreRequest;
use App\Http\Requests\Admin\GlobalOriginalParamChange\UpdateRequest;
use App\Http\Resources\GlobalOriginalParamChangeResource;
use App\Models\GlobalOriginalParamChange;
use App\Services\GlobalOriginalParamChangeServices;
use Illuminate\Http\Request;

class GlobalOriginalParamChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        $global_original_param_change = GlobalOriginalParamChange::paginate(100);
        $global_original_param_changes = GlobalOriginalParamChangeResource::collection($global_original_param_change)->resolve();
        return inertia('Admin/GlobalOriginalParamChange/Index', compact('global_original_param_changes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        $filterTypes = GlobalOriginalParamChangeEnumFilter::collection();
        return inertia('Admin/GlobalOriginalParamChange/Create', compact('filterTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        /////////////////////dd($request);
        $data = $request->validated();
        $global_original_param_change = GlobalOriginalParamChangeServices::store($data);
        return GlobalOriginalParamChangeResource::make($global_original_param_change)->resolve();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(GlobalOriginalParamChange $global_original_param_change)
    {
        $global_original_param_change = GlobalOriginalParamChangeResource::make($global_original_param_change)->resolve();
        return inertia('Admin/GlobalOriginalParamChange/Show', compact('global_original_param_change'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(GlobalOriginalParamChange $global_original_param_change)
    {
        $global_original_param_changes = GlobalOriginalParamChangeResource::collection(GlobalOriginalParamChange::all()->except($global_original_param_change->id))->resolve();
        $global_original_param_change = GlobalOriginalParamChangeResource::make($global_original_param_change)->resolve();
        return inertia('Admin/GlobalOriginalParamChange/Edit', compact('global_original_param_change', 'global_original_param_changes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\GlobalOriginalParamChange\UpdateRequest $request
     * @param int $id
     * @param $global_original_param_change
     * @return array
     */
    public function update(UpdateRequest $request, GlobalOriginalParamChange $global_original_param_change)
    {
        $data = $request->validated();
        $global_original_param_change = GlobalOriginalParamChangeServices::update($global_original_param_change, $data);
        return GlobalOriginalParamChangeResource::make($global_original_param_change)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id

     */
    public function destroy(GlobalOriginalParamChange $global_original_param_change)
    {
        $global_original_param_change->delete();
        return response()->json([
            'message'=>'success'
        ], \Illuminate\Http\Response::HTTP_OK);

    }

}
