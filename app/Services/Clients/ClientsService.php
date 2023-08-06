<?php

namespace App\Services\Clients;

use App\Repositories\Clients\ClientsRepository;

class ClientsService
{

    private ClientsRepository $repository;

    /**
     * @param ClientsRepository $clientsRepository
     */
    public function __construct(ClientsRepository $clientsRepository)
    {
        $this->repository = $clientsRepository;
    }

    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function create(array $params)
    {
        try{
            $client = $this->repository
                ->firstOrCreate($params);
        }catch (\Exception $exception)
        {
            throw new \Exception('Error to create client: ' . $exception->getMessage());
        }

        return $client;
    }
}
