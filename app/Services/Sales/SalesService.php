<?php

namespace App\Services\Sales;

use App\Repositories\Sales\SalesRepository;
use App\Repositories\SalesItems\SalesItemsRepository;
use Illuminate\Support\Facades\DB;

class SalesService
{
    private SalesRepository $repository;
    private SalesItemsRepository $salesItemsRepository;

    /**
     * @param SalesRepository $salesRepository
     * @param SalesItemsRepository $salesItemsRepository
     */
    public function __construct(SalesRepository $salesRepository, SalesItemsRepository $salesItemsRepository)
    {
        $this->repository = $salesRepository;
        $this->salesItemsRepository = $salesItemsRepository;
    }

    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function create(array $params)
    {
        try{
            DB::beginTransaction();

            $sales = $this->repository
                ->create($params);

            $params['sales_id'] = $sales->id;

            $this->salesItemsRepository
                ->create($params);

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            throw new \Exception('Error to create: ' . $exception->getMessage());
        }

        return $sales;
    }
}
