@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checkOut.css') }}">
@endsection

@section('content')

<!-- Delivery Address -->
<div class="deliveryContainer">
    <div class="deliveryAddress">
        <h3>Delivery Address</h3>
    </div>

    <div class="UserDetail">
        <div>Name: {{ $user->name }}</div>
        <div>Phone Number: {{ $user->phone_number ?? 'No phone' }}</div>
        <div>Address: {{ $user->address ?? 'No address' }}</div>
    </div>
</div>

<!-- Checkout -->
<div class="CheckOutContainer">

    <div class="OrderSummaryHead">
        <h3>Order Summary</h3>
    </div>

    @if ($items->isNotEmpty())

        <table>
            <tr>
                <th>Item</th>
                <th>Price (RM)</th>
                <th>Rental Days</th>
                <th>Total</th>
            </tr>

            @foreach ($items as $item)
            <tr>
                <td class="cart-item">
                    <img src="{{ asset($item->product->product_image) }}"><br>
                    {{ $item->product->product_name }}
                </td>

                <td>
                    {{ number_format($item->product->product_price, 2) }}
                </td>

                <td>
                    {{ $item->rental_days }}
                </td>

                <td>
                    RM {{ number_format($item->product->product_price * $item->rental_days, 2) }}
                </td>
            </tr>
            @endforeach
        </table>

    @else
        <p>No items in checkout</p>
    @endif

    

    <!-- Summary -->
    <div class="OrderSummary">

        <div class="SubtotalAndShipping">
            <span>Subtotal</span>
            <span>Shipping</span>
        </div>

        <div class="OrderSummaryPrice">
            <span>RM {{ number_format($subtotal, 2) }}</span>
            <span>RM {{ number_format($shipping, 2) }}</span>
        </div>

    </div>

    <div class="OrderTotal">
        <span>Total</span>
        <span id="totalPrice">
            RM {{ number_format($grand_total, 2) }}
        </span>
    </div>
</div>

<!-- Payment -->
<div class="PaymentMethodContainer">

    <h3>Payment Method</h3>

    <div class="error_Message" id="errorMsg" style="display:none;color:red;">
        Please select a payment method
    </div>

    <div class="PaymentCategory">

        <label class="Card">
            <input type="radio" id="card" name="payment" value="card">
            <div class="paymentContent">
                <img src="{{ asset('images/card.png') }}">
            </div>
        </label>

        <label class="TnG">
            <input type="radio" id="tng" name="payment" value="tng">
            <div class="paymentContent">
                <img src="{{ asset('images/tng.png') }}">
            </div>
        </label>

    </div>

    <div class="checkOutButton">
        <button class="check-out" onclick="goPayment()">Place Order</button>
    </div>

</div>

<script>

function goPayment() {

    const card = document.getElementById("card");
    const tng = document.getElementById("tng");

    if (card.checked) {
        window.location.href = "{{ route('checkout.card') }}";
    }
    else if (tng.checked) {
        window.location.href = "{{ route('checkout.tng') }}";
    }
    else {
        document.getElementById("errorMsg").style.display = "block";
    }
}

document.querySelectorAll('.PaymentCategory label').forEach(label => {
    label.addEventListener('click', () => {

        document.querySelectorAll('.PaymentCategory label')
            .forEach(l => l.classList.remove('selected'));

        label.classList.add('selected');

        label.querySelector('input').checked = true;
    });
});

</script>

@endsection