@php
    $user = Auth::user();
    $is_logged_in = Auth::check();
    $user_id = $is_logged_in ? $user->id : null;
    $full_name = $is_logged_in ? $user->name : null;

    // Cart count for the logged-in user
    $cart_count = 0;
    if ($user_id) {
        try {
            $cart_count = \Illuminate\Support\Facades\DB::table('cart_items')
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->where('carts.user_id', $user_id)
                ->count();
        } catch (\Exception $e) {
            $cart_count = 0;
        }
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/header.css') }}">

<header class="dfy-header">
  <div class="dfy-topbar">
    <a class="dfy-brand" href="{{ url('/') }}">
      <img src="{{ asset('photo/logo.png') }}" alt="logo">
    </a>

    <div class="dfy-right">
      <div class="icon-cart">
        <a id="Cart" href="{{ url('/cart') }}" onclick="checkLogin(event, 'view cart')">
          <img src="{{ asset('photo/shopping cart.png') }}" alt="View Cart" width="50" height="45">
        </a>
        <span>{{ $cart_count }}</span>
      </div>

      @if ($is_logged_in)
        <div class="dfy-user-menu">
          <button
            class="dfy-user"
            type="button"
            aria-expanded="false"
            aria-controls="dfy-user-dropdown"
            onclick="toggleUserMenu(event, this)"
          >
            <span class="dfy-avatar" aria-hidden="true"></span>
            <span class="dfy-username">{{ $full_name ?? ('User #'.$user_id) }}</span>
            <span class="dfy-dropdown-arrow" aria-hidden="true">▾</span>
          </button>

          <div id="dfy-user-dropdown" class="dfy-user-dropdown">
            <a href="{{ route('profile.show', $user_id) }}">User Profile</a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit">Log Out</button>
            </form>
          </div>
        </div>
      @else
        <a class="dfy-login" href="{{ route('login') }}">Log In</a>
      @endif

      <button class="dfy-menu-btn" type="button" aria-expanded="false" aria-controls="dfy-links"
      onclick="(function(btn){var el=document.getElementById('dfy-links');var open=el.classList.toggle('open');
      btn.setAttribute('aria-expanded', open?'true':'false');})(this)">☰</button>
    </div>
  </div>

  <nav id="dfy-links" class="dfy-botnav">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ route('products.index') }}">Product</a>
    <a href="{{ route('contact.form') }}">Contact Us</a>
    @if ($is_logged_in)
      <a href="{{ route('purchase.history') }}">History</a>
    @endif
  </nav>
</header>

<script>
    function checkLogin(event, action) {
        const isLoggedIn = {{ $is_logged_in ? 'true' : 'false' }};
        if (!isLoggedIn) {
            event.preventDefault();
            if (confirm('You need to login first to ' + action + '. Go to login page?')) {
                window.location.href = '{{ route('login') }}';
            }
            return false;
        }
        return true;
    }

    function toggleUserMenu(event, button) {
        event.stopPropagation();

        const dropdown = document.getElementById('dfy-user-dropdown');
        const isOpen = dropdown.classList.toggle('open');

        button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    document.addEventListener('click', function () {
        const dropdown = document.getElementById('dfy-user-dropdown');
        const button = document.querySelector('.dfy-user');

        if (dropdown) {
            dropdown.classList.remove('open');
        }

        if (button) {
            button.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.dispatchEvent(new Event('click'));
        }
    });
</script>