<?php

namespace App\Services\Sales;

use App\Repositories\Sales\SalesRepository;
use App\Repositories\SalesItems\SalesItemsRepository;
use App\Repositories\Stock\StockRepository;
use App\Services\Clients\ClientsService;
use Illuminate\Support\Facades\DB;

class SalesService
{
    private SalesRepository $repository;
    private SalesItemsRepository $salesItemsRepository;
    private ClientsService $clientsService;
    private StockRepository $stockRepository;


    /**
     * @param SalesRepository $salesRepository
     * @param SalesItemsRepository $salesItemsRepository
     * @param ClientsService $clientsService
     * @param StockRepository $stockRepository
     */
    public function __construct
    (
        SalesRepository $salesRepository,
        SalesItemsRepository $salesItemsRepository,
        ClientsService $clientsService,
        StockRepository $stockRepository
    )
    {
        $this->repository = $salesRepository;
        $this->salesItemsRepository = $salesItemsRepository;
        $this->clientsService = $clientsService;
        $this->stockRepository = $stockRepository;
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

            $client = $this->clientsService->create($params['client']);

            $params['client_id'] = $client->id;
            $sales = $this->repository->create($params);

            foreach ($params['products'] as $product){
                $this->salesItemsRepository
                    ->create([
                        'product_id' => $product['product_id'],
                        'sales_id' => $sales->id,
                        'amount' => $product['amount']
                    ]);

                $this->stockRepository->decrementAmount($product['product_id'], $product['amount']);
            }

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            throw new \Exception('Error to create: ' . $exception->getMessage());
        }

        return $sales;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function salesByUser(int $userId)
    {
        return $this->repository
            ->getModel()::where('user_id',$userId)
            ->with(['products','client'])
            ->orderByDesc('id')
            ->get();
    }
}
