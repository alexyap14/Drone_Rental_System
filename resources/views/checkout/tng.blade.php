@extends('layouts.app')

@section('title', 'Touch n Go Payment')

@section('styles')
<style>
.tng_page {
    max-width: 500px;
    margin: 40px auto;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

/* Top Header */
.tng_heading {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    color: white;
    padding: 25px;
}

.tng_heading h3 {
    margin: 0;
    font-size: 16px;
    opacity: 0.9;
}

#price {
    display: block;
    font-size: 32px;
    font-weight: bold;
    margin-top: 10px;
}

/* Content */
.tng_content {
    padding: 30px;
}

.tng_img {
    text-align: center;
    margin-bottom: 20px;
}

.tng_img img {
    width: 120px;
}

/* Login */
.tng_login label {
    display: block;
    margin-top: 15px;
    margin-bottom: 8px;
    font-weight: 500;
}

/* Phone input */
.login_Input {
    display: flex;
    gap: 10px;
}

#country {
    width: 120px;
    padding: 10px;
}

#phone_number {
    flex: 1;
    padding: 10px;
}

/* PIN */
.pin {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.pin input {
    width: 45px;
    height: 45px;
    text-align: center;
    font-size: 18px;
}

/* Button */
.logIn {
    margin-top: 30px;
}

.logIn_Btn {
    width: 100%;
    padding: 12px;
    background: #3b82f6;
    color: white;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}

.logIn_Btn:hover {
    background: #2563eb;
}

/* Error */
.error-message {
    color: red;
    font-size: 13px;
    margin-top: 5px;
    display: none;
}
</style>
@endsection

@section('content')
<div class="tng_page">

    <!-- HEADER -->
    <div class="tng_heading">
        <h3>Payment to Drone FY</h3>
        <span id="price">
            RM {{ number_format(session('grand_total', 0), 2) }}
        </span>
    </div>

    <!-- CONTENT -->
    <div class="tng_content">

        <!-- LOGO -->
        <div class="tng_img">
            <img src="{{ asset('images/tng.png') }}" alt="TNG">
        </div>

        <div class="tng_login">

            <label>Mobile Number</label>

            <div class="login_Input">
                <select id="country">
                    <option value="+60">MY +60</option>
                </select>

                <input type="text" id="phone_number" placeholder="Mobile Number">
            </div>

            <div class="error-message" id="phoneError">
                Please enter valid phone number
            </div>

            <label>6 Digit PIN</label>

            <div class="pin">
                <input type="password" maxlength="1" class="otp">
                <input type="password" maxlength="1" class="otp">
                <input type="password" maxlength="1" class="otp">
                <input type="password" maxlength="1" class="otp">
                <input type="password" maxlength="1" class="otp">
                <input type="password" maxlength="1" class="otp">
            </div>

            <div class="error-message" id="pinError">
                Please enter 6-digit PIN
            </div>

            <div class="logIn">
                <button class="logIn_Btn" onclick="handlePayment()">Log In</button>
            </div>

        </div>
    </div>
</div>

<script>
// OTP auto move
document.querySelectorAll('.otp').forEach((input, index, inputs) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });
});

// Payment validation
function handlePayment() {
    const phone = document.getElementById('phone_number').value;
    const pins = document.querySelectorAll('.otp');

    let pinValue = '';
    pins.forEach(p => pinValue += p.value);

    let valid = true;

    // Phone check
    if (phone.length < 9) {
        document.getElementById('phoneError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('phoneError').style.display = 'none';
    }

    // PIN check
    if (pinValue.length !== 6) {
        document.getElementById('pinError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('pinError').style.display = 'none';
    }

    if (valid) {
        // 模擬成功
        window.location.href = "{{ route('checkout.done') }}";
    }
}
</script>
@endsection