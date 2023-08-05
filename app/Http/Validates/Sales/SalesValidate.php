<?php

namespace App\Http\Validates\Sales;

use Illuminate\Http\Request;

class SalesValidate
{
    public static function store(Request $request) : void
    {
        $request->validate([
            'name' => 'required',
        ]);
    }

}
