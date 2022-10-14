@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <h1> Selamat datang <span class="text-success"> {{ Auth::user()->name }} </span> di Dashboard </h1>
@endsection