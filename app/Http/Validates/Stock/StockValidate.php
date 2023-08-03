<?php

namespace App\Http\Validates\Stock;

use Illuminate\Http\Request;

class StockValidate
{
    public static function store(Request $request) : void
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required',
        ]);
    }
}
