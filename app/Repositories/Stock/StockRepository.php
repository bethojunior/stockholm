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

}
