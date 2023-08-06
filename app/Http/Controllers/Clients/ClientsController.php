<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Validates\Clients\ClientsValidate;
use App\Services\Clients\ClientsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    private ClientsService $service;
    private ClientsValidate $validate;

    /**
     * @param ClientsService $clientsService
     * @param ClientsValidate $clientsValidate
     */
    public function __construct(
        ClientsService $clientsService,
        ClientsValidate $clientsValidate
    )
    {
        $this->service = $clientsService;
        $this->validate = $clientsValidate;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate::store($request);

        try{
            $client = $this->service
                ->create($request->all());
        }catch (\Exception $exception)
        {
            return ApiResponse::error('','Error to create client: ' . $exception->getMessage());
        }

        return ApiResponse::created($client,'Client created with success');
    }

}
