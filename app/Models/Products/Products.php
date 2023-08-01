<?php

namespace App\Models\Products;

use App\Models\StockProducts\StockProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    protected $fillable = [
        'name',
        'image',
        'value'
    ];

    protected $casts = [
        'value' => 'float'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function amount(): BelongsTo
    {
        return $this->belongsTo(StockProducts::class);
    }
}
