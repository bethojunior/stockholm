<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Stock\StockValidate;
use App\Services\Products\ProductsService;
use App\Services\Stock\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{

    private StockService $service;
    private StockValidate $validate;
    private ProductsService $productsService;

    /**
     * @param StockService $stockService
     * @param StockValidate $stockValidate
     * @param ProductsService $productsService
     */
    public function __construct(
        StockService $stockService,
        StockValidate $stockValidate,
        ProductsService $productsService
    )
    {
        $this->service = $stockService;
        $this->validate = $stockValidate;
        $this->productsService = $productsService;
    }

    public function index()
    {
        dd('ok');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create() : View
    {
        $products = $this->productsService->list();
        return view('admin.stock.create')->with([
            'products' => $products
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
            $stock = $this->service
                ->create($request->all());
        }catch (\Exception $exception)
        {
            return ApiResponse::error('','Error to create stock: ' . $exception->getMessage());
        }

        return ApiResponse::created($stock,'Create with success');
    }

}
