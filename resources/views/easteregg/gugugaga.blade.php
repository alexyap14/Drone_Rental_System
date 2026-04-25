@extends('layouts.app')

@section('title', '???')

@section('content')
<div style="
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:70vh;
">
    <div style="
        background:#fff;
        padding:40px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
        text-align:center;
        max-width:500px;
        width:100%;
    ">

        <img src="{{ asset('images/meme.jpg') }}" 
             style="max-width:100%; border-radius:8px; margin-bottom:20px;">

        <h2 style="margin-bottom:20px;">why are u here！😐</h2>

        <!-- Button -->
        <button onclick="window.location.href='{{ route('home') }}'"
            style="
                padding:10px 20px;
                background:#007bff;
                color:white;
                border:none;
                border-radius:8px;
                cursor:pointer;
            ">
            Back to Home
        </button>

    </div>
</div>
@endsection