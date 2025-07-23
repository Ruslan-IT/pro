<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SuppliersTovars\StoreRequest;
use App\Http\Requests\Admin\SuppliersTovars\UpdateRequest;
use App\Http\Resources\SuppliersTovarsResource;
use App\Models\SuppliersTovars;
use App\Services\SuppliersTovarsServices;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Response;

class SuppliersTovarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        //$tovars = SuppliersTovars::all();
        //$tovars = SuppliersTovarsResource::collection($tovars)->resolve();
        //dd($tovars);
        return inertia('Admin/SuppliersTovars/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        return inertia('admin/SuppliersTovars/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $tovar = SuppliersTovarsServices::store($data);
        return SuppliersTovarsResource::make($tovar)->resolve();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(SuppliersTovars $tovars)
    {
        $tovars = SuppliersTovars::make($tovars)->resolve();
        return inertia('admin/SuppliersTovars/show', compact('tovars'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(SuppliersTovars $tovars)
    {
        $tovars = SuppliersTovars::make($tovars)->resolve();
        return inertia('admin/SuppliersTovars/edit', compact('tovars'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @param $tovar
     * @return array
     */
    public function update(UpdateRequest $request, SuppliersTovars $tovar)
    {
        $data = $request->validated();
        $tovar = SuppliersTovarsServices::update($tovar, $data);
        return SuppliersTovarsResource::make($tovar)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id

     */
    public function destroy(SuppliersTovars $tovars)
    {
        $tovars->delete();
        return response()->json([
            'message'=>'success'
        ], \Illuminate\Http\Response::HTTP_OK);
    }
}
