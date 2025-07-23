<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;

use App\Http\Resources\CatalogsResource;
use App\Http\Resources\GlobalOriginalParamChangeResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\GlobalOriginalParamChange;
use App\Models\Param;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Http\Request;


#[ObservedBy(ProductObserver::class)]

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->limit(10)->get();
        $products = ProductResource::collection($products)->resolve();
        return inertia('Admin/Product/Index',
            compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        $categories = CatalogsResource::collection(Category::all())->resolve();
        $global_original_param_change = CatalogsResource::collection(Category::all())->resolve();

        $params = ParamResource::collection(Param::all())->resolve();
        //$global_original_param_change = GlobalOriginalParamChangeResource::collection(GlobalOriginalParamChange::all())->resolve();
        return inertia('Admin/Product/Create', compact('categories',  'global_original_param_change', 'params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(StoreRequest $request)
    {

        //$data = $request->validated();
        $data = $request->validationData();

        $product = ProductService::store($data);

        return ProductResource::make($product)->resolve();

    }


    public function show(Product $product)
    {
        $product = ProductResource::make($product)->resolve();
        return inertia('Admin/Product/Show', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = CatalogsResource::collection(Category::all())->resolve();
        $global_original_param_change = CatalogsResource::collection(Category::all())->resolve();

        //$product = Product::limit(10)->get();
        $product = ProductResource::make($product)->resolve();
        return inertia('Admin/Product/Edit', compact('product',  'categories'));
    }


    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = ProductService::update($product, $data);
        return ProductResource::make($product)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
