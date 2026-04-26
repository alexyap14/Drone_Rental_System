<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfileDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    // ========== TWO‑STEP REGISTRATION (Session‑based) ==========
    public function showSetupForm()
    {
        return view('auth.profile_setup');
    }

    public function postSetup(Request $request)
    {
        // Validate the profile fields
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'address' => 'required|string',
        ]);

        // Get the registration data from session
        $registerData = Session::get('registration_data');

        if (!$registerData) {
            return redirect()->route('register')->with('error', 'Session expired. Please start again.');
        }

        // Create the user
        $user = User::create([
            'email' => $registerData['email'],
            'password' => $registerData['password'],
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => 'user',
        ]);

        // Log the user in and clear session
        Auth::login($user);
        Session::forget('registration_data');

        return redirect('/');
    }

    // ========== PROFILE VIEWING / EDITING (Existing users) ==========
    public function show(User $user)
    {
        $user->load('profileDetail');
        // Authorization: only owner or admin
        if (Gate::denies('view-profile', $user)) {
            abort(403, 'Unauthorized');
        }

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        if (Gate::denies('update-profile', $user)) {
            abort(403, 'Unauthorized');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (Gate::denies('update-profile', $user)) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|string|max:50',
            'race' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
        ]);

        // Update users table
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? '',
            'address' => $validated['address'] ?? '',
        ]);

        // Update or create profile_details
        ProfileDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $validated['name'],         
                'phone' => $validated['phone_number'], 
                'address' => $validated['address'],
                'gender' => $validated['gender'] ?? null,
                'race' => $validated['race'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'date_of_birth' => $validated['dob'] ?? null,
            ]
        );

        session()->flash('success', 'Profile updated successfully.');
        return redirect()->route('profile.show', $user);
    }

    // ========== PROFILE SETUP FOR ALREADY‑LOGGED‑IN USERS (without profile) ==========
    public function setup()
    {
        // If user already has a profile_details record, redirect to edit
        if (ProfileDetail::where('user_id', Auth::id())->exists()) {
            return redirect()->route('profile.edit');
        }
        return view('profile.setup');
    }

    // Optional: store the setup form (if you want to separate from update)
    public function storeSetup(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'gender' => 'nullable|string|max:50',
            'race' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
        ]);

        ProfileDetail::create([
            'user_id' => $user->id,
            'gender' => $validated['gender'] ?? null,
            'race' => $validated['race'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
        ]);

        return redirect()->route('home')->with('success', 'Profile details saved!');
    }
}