@extends('layouts.app')

@section('title', 'Payment Success')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checkOutDone.css') }}">
@endsection

@section('content')
<div class="checkContainer">

    <div class="checkImg">
        <img src="{{ asset('images/checked.png') }}" alt="success">
    </div>

    <div class="succefullLabel">
        <span>You've successfully booked your drone! 🎉</span>
    </div>

    <div class="button">

        <div class="succesButton">
            <button onclick="window.location.href='{{ route('products.index') }}'">
                Back to Home
            </button>
        </div>

        <div class="historyButton">
            <button onclick="window.location.href='{{ route('purchase.history') }}'">
                View History
            </button>
        </div>

    </div>

</div>
@endsection