<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesLoginController extends Controller
{
    /**
     * Show the sales login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('sales.auth.login'); // This view already exists
    }

    /**
     * Handle a sales login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the sales representative using the 'sales' guard
        if (Auth::guard('sales')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Redirect to the sales dashboard
            return redirect()->intended(route('sales.dashboard'))->with('success', 'Anda berhasil login sebagai Sales!');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Log the sales representative out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('sales')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sales/login')->with('success', 'Anda telah berhasil logout.');
    }
}
