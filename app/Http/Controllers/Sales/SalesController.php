<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Sales\SalesValidate;
use App\Services\Sales\SalesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesController extends Controller
{

    private SalesService $service;
    private SalesValidate $validate;

    /**
     * @param SalesService $salesService
     * @param SalesValidate $salesValidate
     */
    public function __construct(SalesService $salesService, SalesValidate $salesValidate)
    {
        $this->service = $salesService;
        $this->validate = $salesValidate;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate::store($request);

        try{
            $sales = $this->service
                ->create($request->all());
        }catch (\Exception $e)
        {
            return ApiResponse::error('', $e->getMessage());
        }

        return $sales;
    }
}
