@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])
{{--    @dump(auth()->user()->createToken('tokens')->plainTextToken);--}}
    <div id="app">
        <create-product-component :token="{{ @json_encode($token) }}" :logged="{{ auth()->user() }}"></create-product-component>
    </div>
@endsection
