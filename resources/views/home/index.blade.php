@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])

    <div id="app">
        <home-component :logged="{{ auth()->user() }}"></home-component>
    </div>
@endsection
