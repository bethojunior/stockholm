<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Products\ProductsValidate;
use App\Services\Products\ProductsService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    private ProductsService $service;
    private ProductsValidate $validate;

    /**
     * @param ProductsService $productsService
     * @param ProductsValidate $productsValidate
     */
    public function __construct(ProductsService $productsService, ProductsValidate $productsValidate)
    {
        $this->service = $productsService;
        $this->validate = $productsValidate;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('admin.products.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate::store($request);

        try{
            $product = $this->service
                ->create($request->all());
        }catch (\Exception $exception)
        {
            return ApiResponse::error('','Error to create product: '.$exception->getMessage(),'400');
        }

        return ApiResponse::created($product,'Product created');
    }

}
