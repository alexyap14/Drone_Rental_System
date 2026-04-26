@extends('layouts.app')

@section('content')
<div class="profile-hero">
    <div class="profile-card">
        <h1>My Profile</h1>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <div class="col">
                <h3>Basic Info</h3>
                <div class="form-row">
                    <label>Full Name</label>
                    <p>{{ $user->name }}</p>
                </div>
                <div class="form-row">
                    <label>Email</label>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="form-row">
                    <label>Phone</label>
                    <p>{{ $user->phone_number ?? 'Not provided' }}</p>
                </div>
                <div class="form-row">
                    <label>Address</label>
                    <p>{{ $user->address ?? 'Not provided' }}</p>
                </div>
            </div>
            <div class="col">
                <h3>Additional Details</h3>
                <div class="form-row">
                    <label>Gender</label>
                    <p>{{ $user->profileDetail->gender ?? '—' }}</p>
                </div>
                <div class="form-row">
                    <label>Race</label>
                    <p>{{ $user->profileDetail->race ?? '—' }}</p>
                </div>
                <div class="form-row">
                    <label>Religion</label>
                    <p>{{ $user->profileDetail->religion ?? '—' }}</p>
                </div>
                <div class="form-row">
                    <label>Date of Birth</label>
                    <p>{{ $user->profileDetail->date_of_birth ?? '—' }}</p>
                </div>
                @can('update-profile', $user)
                <div class="form-actions">
                    <a href="{{ route('profile.edit') }}" class="btn primary">Edit Profile</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection