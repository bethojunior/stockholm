<?php

namespace App\Http\Validates\Products;
use Illuminate\Http\Request;
class ProductsValidate
{
    public static function store(Request $request) : void
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'value' => 'required',
        ]);
    }

}
