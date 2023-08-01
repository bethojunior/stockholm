@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])

    <div id="app">
        <create-product-component :logged="{{ auth()->user() }}"></create-product-component>
    </div>
@endsection
