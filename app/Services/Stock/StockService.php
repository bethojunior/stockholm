<?php

namespace App\Services\Stock;

use App\Repositories\Stock\StockRepository;

class StockService
{

    private StockRepository $repository;

    /**
     * @param StockRepository $stockRepository
     */
    public function __construct(StockRepository $stockRepository)
    {
        $this->repository = $stockRepository;
    }

    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function create(array $params)
    {
        try{
            $stock = $this->repository
                ->updateOrCreate($params);
        }catch (\Exception $exception)
        {
            throw new \Exception('Error to create: ' . $exception->getMessage());
        }

        return $stock;
    }

}
