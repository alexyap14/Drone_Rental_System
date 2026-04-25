@extends('layouts.app')

@section('title', 'Credit Card Payment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/creditcard.css') }}">
@endsection

@section('content')
<div class="credit_card_page">

    <form id="paymentForm" onsubmit="return handleSubmit(event)">
        <h2>Add Card</h2>

        <div class="credit_card_page_head">
            <h3>Card Details</h3>
            <div class="master_visa_img">
                <img src="{{ asset('images/visaMasterCard.png') }}" alt="Visa/MasterCard">
            </div>
        </div>

        <div class="cardDetail">

            <div class="cardNumber">
                <label>Card Number</label>
                <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456">
                <div class="error-message" id="cardNumberError">Invalid card number</div>
            </div>

            <div class="cardExpiry">
                <div>
                    <label>Expiry</label>
                    <input type="text" id="cardExpiry" placeholder="MM/YY">
                    <div class="error-message" id="expiryError">Invalid expiry</div>
                </div>

                <div>
                    <label>CVV</label>
                    <input type="text" id="cardCVV" placeholder="123">
                    <div class="error-message" id="cvvError">Invalid CVV</div>
                </div>
            </div>

            <div class="cardName">
                <label>Name on Card</label>
                <input type="text" id="cardName" placeholder="Your Name">
                <div class="error-message" id="cardNameError">Enter name</div>
            </div>
        </div>

        <div class="billing-section">
            <h3>Billing Address</h3>

            <div>
                <label>Address</label>
                <input type="text" id="cardAddress" placeholder="123 Street">
            </div>

            <div>
                <label>Postal Code</label>
                <input type="text" id="postalCode" placeholder="43200">
            </div>
        </div>

        <div class="acknowledgement">
            Payment to Drone FY:  
            <b>RM {{ number_format(session('grand_total', 0), 2) }}</b>
        </div>

        <div class="cancenl_submit_button">
            <button type="button" onclick="window.location.href='{{ route('checkout.index') }}'">
                Cancel
            </button>

            <button type="submit">Pay</button>
        </div>
    </form>

</div>

<script>
function handleSubmit(e) {
    e.preventDefault();

    const card = document.getElementById('cardNumber').value;
    const cvv = document.getElementById('cardCVV').value;
    const expiry = document.getElementById('cardExpiry').value;

    let valid = true;

    if (card.length < 16) {
        document.getElementById('cardNumberError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('cardNumberError').style.display = 'none';
    }

    if (cvv.length !== 3) {
        document.getElementById('cvvError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('cvvError').style.display = 'none';
    }

    if (expiry.length !== 5) {
        document.getElementById('expiryError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('expiryError').style.display = 'none';
    }

    if (valid) {
        window.location.href = "{{ route('checkout.done') }}";
    }
}
</script>
@endsection