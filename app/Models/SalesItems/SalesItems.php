<?php

namespace App\Models\SalesItems;

use App\Models\Products\Products;
use App\Models\Sales\Sales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesItems extends Model
{
    protected $fillable = [
        'sales_id',
        'product_id',
        'amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sales::class,'sales_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class,'product_id');
    }

}
