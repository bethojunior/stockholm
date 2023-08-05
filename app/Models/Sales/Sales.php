<?php

namespace App\Models\Sales;

use App\Models\Clients\Clients;
use App\Models\SalesItems\SalesItems;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    protected $fillable = [
        'user_id',
        'value',
        'payment_method',
        'client_id'
    ];

    protected $casts = [
        'value' => 'float'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(SalesItems::class);
    }
}
