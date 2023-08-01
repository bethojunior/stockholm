@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])

    <div id="app">
        <list-products-component
            :token="{{ @json_encode(auth()->user()->createToken('tokens')->plainTextToken) }}"
            :logged="{{ auth()->user() }}"
            :products="{{ $products }}">
        </list-products-component>
    </div>
@endsection
