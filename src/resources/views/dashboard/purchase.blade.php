@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
<livewire:payments :item="$item" />
@endsection