@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])

    <div id="app">
        <create-product-component
            :token="{{ @json_encode(auth()->user()->createToken('tokens')->plainTextToken) }}"
            :logged="{{ auth()->user() }}">
        </create-product-component>
    </div>

@endsection
