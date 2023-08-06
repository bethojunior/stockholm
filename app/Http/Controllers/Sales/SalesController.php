<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Sales\SalesValidate;
use App\Services\Products\ProductsService;
use App\Services\Sales\SalesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesController extends Controller
{

    private SalesService $service;
    private SalesValidate $validate;
    private ProductsService $productsService;

    /**
     * @param SalesService $salesService
     * @param SalesValidate $salesValidate
     * @param ProductsService $productsService
     */
    public function __construct(
        SalesService $salesService,
        SalesValidate $salesValidate,
        ProductsService $productsService
    )
    {
        $this->service = $salesService;
        $this->validate = $salesValidate;
        $this->productsService = $productsService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(): View
    {
        $products = $this->productsService->list();

        return view('admin.sales.index')->with([
            'products' => $products
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate::store($request);

        dd($request->all());
//        try{
//            $sales = $this->service
//                ->create($request->all());
//        }catch (\Exception $e)
//        {
//            return ApiResponse::error('', $e->getMessage());
//        }
//
//        return $sales;
    }
}
