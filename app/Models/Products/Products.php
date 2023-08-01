<?php

namespace App\Models\Products;

use App\Models\StockProducts\StockProducts;
use Illuminate\Database\Eloquent\Model;

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

    public function amount()
    {
        return $this->belongsTo(StockProducts::class);
    }
}
