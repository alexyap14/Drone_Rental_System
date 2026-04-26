@extends('layouts.app')

@section('content')
<div class="profile-hero">
    <div class="profile-card">
        <h1>My Profile</h1>

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="grid">
                <!-- Basic Info -->
                <div class="col">
                    <h3>Basic Info</h3>

                    <div class="form-row">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <small class="err">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-row">
                        <label for="email">Email (read-only)</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $user->email) }}" readonly>
                    </div>

                    <div class="form-row">
                        <label for="phone_number">Phone *</label>
                        <input type="text" id="phone_number" name="phone_number"
                               value="{{ old('phone_number', $user->phone_number ?? '') }}" required>
                        @error('phone_number') <small class="err">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-row">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address"
                               value="{{ old('address', $user->address ?? '') }}">
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="col">
                    <h3>Additional Details</h3>

                    <div class="form-row">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">— Select —</option>
                            <option value="Male"   {{ old('gender', $user->profileDetail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->profileDetail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other"  {{ old('gender', $user->profileDetail->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="race">Race</label>
                        <input type="text" id="race" name="race"
                               value="{{ old('race', $user->profileDetail->race ?? '') }}">
                    </div>

                    <div class="form-row">
                        <label for="religion">Religion</label>
                        <input type="text" id="religion" name="religion"
                               value="{{ old('religion', $user->profileDetail->religion ?? '') }}">
                    </div>

                    <div class="form-row">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob"
                               value="{{ old('dob', $user->profileDetail->date_of_birth ?? '') }}">
                        @error('dob') <small class="err">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Save Changes</button>
                <a href="{{ route('profile.show', $user) }}" class="btn ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection