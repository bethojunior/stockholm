@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])

    <div id="app">
        <create-stock-component
            :products="{{ $products }}"
            :token="{{ @json_encode(auth()->user()->createToken('tokens')->plainTextToken) }}"
            :logged="{{ auth()->user() }}">
        </create-stock-component>
    </div>

@endsection
