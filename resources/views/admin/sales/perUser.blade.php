@extends('includes.index')

@section('content')
    @vite(['resources/js/app.js'])
    <h4>Minhas vendas</h4>
    <hr>
    @foreach($sales as $sale)
        <div class="card p-3">
{{--            {{ $sale }}--}}
            <span>Cliente:  <b>{{ $sale->client->name }}</b></span>
            <span>Valor total: <b>R${{ $sale->value }}</b></span>
            <span>Data: <b>{{ \Illuminate\Support\Carbon::parse($sale->created_at)->format('d/m/y h:m') }}</b></span>

        </div>
    @endforeach

@endsection
