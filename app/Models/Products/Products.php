<?php

namespace App\Models\Products;

use App\Models\StockProducts\StockProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'value',
        'description'
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
