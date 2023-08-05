<?php

namespace App\Repositories\Sales;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Sales\Sales;

class SalesRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Sales::class);
    }
}
