<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Catalogs\StoreRequest;
use App\Http\Requests\Admin\Catalogs\UpdateRequest;
use App\Http\Resources\CatalogsResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CatalogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        $catalog = Category::all();
        $catalogs = CatalogsResource::collection($catalog)->resolve();
        return inertia('Admin/Catalog/Index', compact('catalogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        $catalogs = CatalogsResource::collection(Category::all())->resolve();
        return inertia('Admin/Catalog/Create', compact('catalogs'));
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
        $catalog = CategoryService::store($data);
        return CatalogsResource::make($catalog)->resolve();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(Category $catalog)
    {
        $catalog = CatalogsResource::make($catalog)->resolve();
        return inertia('Admin/Catalog/Show', compact('catalog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(Category $catalog)
    {

        $catalogs = CatalogsResource::collection(Category::all()->except($catalog->id))->resolve();
        $catalog = CatalogsResource::make($catalog)->resolve();
        return inertia('Admin/Catalog/Edit', compact('catalog', 'catalogs'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\Catalogs\UpdateRequest $request
     * @param int $id
     * @param $catalog
     * @return array
     */
    public function update(UpdateRequest $request, Category $catalog)
    {
        $data = $request->validated();
        $catalog = CategoryService::update($catalog, $data);
        return CatalogsResource::make($catalog)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id

     */
    public function destroy(Category $catalog)
    {
        $catalog->delete();
        return response()->json([
            'message'=>'success'
        ], \Illuminate\Http\Response::HTTP_OK);

    }

}
