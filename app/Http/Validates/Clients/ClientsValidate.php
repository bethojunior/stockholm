<?php

namespace App\Http\Validates\Clients;

use Illuminate\Http\Request;

class ClientsValidate
{

    public static function store(Request $request) : void
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
    }
}
