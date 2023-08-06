<?php

namespace App\Http\Validates\Sales;

use Illuminate\Http\Request;

class SalesValidate
{
    public static function store(Request $request) : void
    {
        $request->validate([
            'products' => 'required|array',
            'user_id'  => 'required|exists:users,id',
            'payment_method' => 'required',
            'client' => 'required',
            'value' => 'required'
        ]);
    }

}
