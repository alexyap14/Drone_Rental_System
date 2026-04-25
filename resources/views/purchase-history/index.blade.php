@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="margin-bottom:20px;">Booking History</h2>

    @if ($orders->isEmpty())
        <div style="padding:20px; background:#f5f5f5; border-radius:10px;">
            You haven't made any bookings yet.
            <br><br>
            <a href="{{ route('home') }}" 
               style="padding:10px 15px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">
               Browse Drones
            </a>
        </div>
    @else

        @foreach ($orders as $groupId => $group)

            <div style="
                background:#fff;
                border-radius:12px;
                padding:20px;
                margin-bottom:20px;
                box-shadow:0 4px 10px rgba(0,0,0,0.05);
            ">

                {{-- 🔹 Order Header --}}
                <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                    <strong>Booking #{{ $groupId }}</strong>
                    <strong>RM {{ number_format($group->sum('total_price'), 2) }}</strong>
                </div>

                {{-- 🔹 Items --}}
                @foreach ($group as $item)

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        padding:10px 0;
                        border-top:1px solid #eee;
                    ">

                        <div>
                            <div style="font-weight:500;">
                                Drone ID: {{ $item->drone_id }}
                            </div>

                            <div style="font-size:13px; color:#666;">
                                Rental: {{ $item->rental_date }} <br>
                                Return: {{ $item->return_date }} <br>
                                Status: {{ $item->status }}
                            </div>
                        </div>

                        <div style="text-align:right;">
                            <strong>
                                RM {{ number_format($item->total_price, 2) }}
                            </strong>
                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

    @endif
</div>
@endsection