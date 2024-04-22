<?php

namespace App\Services\Sales;

use App\Repositories\Sales\SalesRepository;
use App\Repositories\SalesItems\SalesItemsRepository;
use App\Repositories\Stock\StockRepository;
use App\Services\Clients\ClientsService;
use Error;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
    public function __construct(
        SalesRepository $salesRepository,
        SalesItemsRepository $salesItemsRepository,
        ClientsService $clientsService,
        StockRepository $stockRepository
    ) {
        $this->repository = $salesRepository;
        $this->salesItemsRepository = $salesItemsRepository;
        $this->clientsService = $clientsService;
        $this->stockRepository = $stockRepository;
    }


    public function create(array $params): Builder | Model
    {
        try {
            DB::beginTransaction();

            $client = $this->clientsService->create($params['client']);

            if ($client instanceof Exception)
                throw new \Exception('Error to create cliente');

            $params['client_id'] = $client->id;
            $sales = $this->repository->create($params);

            if ($sales instanceof Exception)
                throw new \Exception('Error to create sales item');

            foreach ($params['products'] as $product) {
                $this->salesItemsRepository
                    ->create([
                        'product_id' => $product["item"]["product_id"],
                        'sales_id' => $sales->id,
                        'amount' => $product["item"]["amount"]
                    ]);

                //todo validate this code why decrement amount field
                $this->stockRepository->decrementAmount($product["item"]['product_id'], $product['amount']);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('Error: ' . $exception->getMessage());
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
            ->getModel()::where('user_id', $userId)
            ->with(['products', 'client'])
            ->orderByDesc('id')
            ->get();
    }
}
