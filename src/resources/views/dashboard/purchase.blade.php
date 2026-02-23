@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('script')
<script src="https://js.stripe.com/clover/stripe.js"></script>
@endsection

@section('content')
<livewire:payments :item="$item" />
@endsection