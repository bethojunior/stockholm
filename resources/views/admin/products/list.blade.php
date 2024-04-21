@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <div id="app">
        <list-products-component
            :token="{{ @json_encode(auth()->user()->createToken('tokens')->plainTextToken) }}"
            :logged="{{ auth()->user() }}"
            :products="{{ $products }}">
        </list-products-component>
    </div>
@endsection
