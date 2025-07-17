<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $customer = Customer::where('google_id', $googleUser->getId())->first();

            if ($customer) {
                if ($customer->status === 'ACTIVE') {
                    Auth::guard('customer')->login($customer);
                    $request->session()->regenerate();
                    return redirect()->route('home')->with('success', 'Selamat datang, ' . $customer->name_store . '!');
                } else {
                    $message = $customer->status === 'PENDING_APPROVE' 
                        ? 'Akun Anda sedang menunggu persetujuan admin.' 
                        : 'Akun Anda tidak aktif.';
                    return redirect()->route('login')->withErrors(['email' => $message]);
                }
            } else {
                session()->put('google_user_data', $googleUser);
                return redirect()->route('google.register.form');
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            return redirect()->route('login')->withErrors(['email' => 'Terjadi kesalahan saat otentikasi dengan Google.']);
        }
    }

    public function showRegisterForm()
    {
        if (!session()->has('google_user_data')) {
            return redirect()->route('login');
        }
        return view('auth.google-register');
    }

    public function processRegistration(Request $request)
    {
        if (!session()->has('google_user_data')) {
            return redirect()->route('login');
        }

        $request->validate([
            'name_store' => 'required|string|max:255',
            'no_phone'   => 'required|string|max:20',
            'address'    => 'required|string|max:255',
        ]);

        $googleUser = session('google_user_data');

        Customer::create([
            'name_owner' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password' => Hash::make(uniqid()),
            'name_store' => $request->name_store,
            'no_phone' => $request->no_phone,
            'address' => $request->address,
            'status' => 'PENDING_APPROVE',
            'credit_limit' => 0,
        ]);

        session()->forget('google_user_data');
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda akan segera diaktifkan oleh admin.');
    }
}