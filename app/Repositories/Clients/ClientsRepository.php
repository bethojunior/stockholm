<?php

namespace App\Repositories\Clients;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Clients\Clients;

class ClientsRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Clients::class);
    }
}
