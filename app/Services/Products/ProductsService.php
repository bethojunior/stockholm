<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductsRepository;
use Mockery\Exception;

class ProductsService
{

    private  ProductsRepository $repository;

    /**
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->repository = $productsRepository;
    }

    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $params)
    {
        try{
            $product = $this->repository->create($params);
        }catch (\Exception $exception){
            throw new Exception('Error to create product: '. $exception->getMessage());
        }

        return $product;
    }

}
