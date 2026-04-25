<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DroneFY - Profile Setup</title>

    <!-- Laravel asset -->
    <link rel="stylesheet" href="{{ asset('css/profile_setup.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="225">
        </div>
        <div class="auth-links">
            <a href="{{ route('register') }}" class="auth-link">Sign up</a>
            <a href="{{ route('login') }}" class="auth-link">Log in</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">

            <!-- Left Section -->
            <div class="welcome-section">
                <h1 class="welcome-title">Complete Your Profile</h1>
                <p class="welcome-text">
                    Join thousands of users who trust us. Complete your profile to get started.
                </p>

                <ul class="features">
                    <li><span class="feature-icon">✓</span> Secure data encryption</li>
                    <li><span class="feature-icon">✓</span> 24/7 customer support</li>
                    <li><span class="feature-icon">✓</span> Access to exclusive features</li>
                </ul>
            </div>

            <!-- Form -->
            <div class="profile-form-container">
                <div class="form-header">
                    <h2 class="form-title">Profile Setup</h2>
                    <p class="form-subtitle">Please provide your information</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success -->
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="profile-form" method="POST" action="{{ route('profile.setup.post') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input 
                            type="text" 
                            class="form-input" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Enter your full name" 
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input 
                            type="tel" 
                            class="form-input" 
                            name="phone_number" 
                            value="{{ old('phone_number') }}"
                            placeholder="Enter your phone number" 
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input 
                            type="text" 
                            class="form-input" 
                            name="address" 
                            value="{{ old('address') }}"
                            placeholder="Enter your address" 
                            required>
                    </div>

                    <button type="submit" class="setup-button">Complete Setup</button>
                </form>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="copyright">© {{ date('Y') }} DroneFY. All rights reserved.</div>
    </div>

   
    <script>
        document.querySelector('.profile-form').addEventListener('submit', function(e) {
            const name = this.name.value.trim();
            const phoneNumber = this.phone_number.value.trim();
            const address = this.address.value.trim();

            if (!name || !phoneNumber || !address) {
                alert('All fields are required.');
                e.preventDefault();
            }
        });
    </script>

</body>
</html>