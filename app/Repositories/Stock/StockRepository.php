<?php

namespace App\Repositories\Stock;

use App\Contracts\Repository\AbstractRepository;
use App\Models\StockProducts\StockProducts;

class StockRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->setModel(StockProducts::class);
    }

    /**
     * @param int $productId
     * @param float $amount
     * @return void
     */
    public function decrementAmount(int $productId, float $amount): void
    {
        $item = $this->find($productId);
        $item->update([
            'amount' => ($item->amount - $amount)
        ]);
    }

}
