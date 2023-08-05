<?php

namespace App\Repositories\SalesItems;

use App\Contracts\Repository\AbstractRepository;
use App\Models\SalesItems\SalesItems;

class SalesItemsRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->setModel(SalesItems::class);
    }

}
