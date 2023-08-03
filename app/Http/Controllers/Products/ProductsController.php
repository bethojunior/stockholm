<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Products\ProductsValidate;
use App\Services\Products\ProductsService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{

    private ProductsService $service;
    private ProductsValidate $validate;
    private UserService $userService;

    /**
     * @param ProductsService $productsService
     * @param ProductsValidate $productsValidate
     * @param UserService $userService
     */
    public function __construct(
        ProductsService $productsService,
        ProductsValidate $productsValidate,
        UserService $userService
    )
    {
        $this->service = $productsService;
        $this->validate = $productsValidate;
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(): View
    {
        $products = $this->service->list();

        return view('admin.products.list')->with([
            'products' => $products
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index() : View
    {
        $token = $this->userService->tokenUserLogged();

        return view('admin.products.create')->with([
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
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

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $product = $this->service
                ->destroy($id);
        }catch (\Exception $exception)
        {
            return ApiResponse::error('','Error to destroy product: '. $exception->getMessage());
        }

        return ApiResponse::success($product,'Product deleted with success');
    }

}
