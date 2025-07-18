<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales; // Pastikan model Sales di-import

class SalesLoginController extends Controller
{
    /**
     * Membuat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:sales')->except('logout');
    }

    /**
     * Menampilkan form login untuk sales.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('sales.auth.login');
    }

    /**
     * Menangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        // 2. Mencoba untuk melakukan otentikasi
        if (Auth::guard('sales')->attempt($credentials, $request->filled('remember'))) {
            // Jika kredensial (email & password) benar, ambil data user
            $user = Auth::guard('sales')->user();

            // 3. PERIKSA STATUS AKUN
            if ($user->status !== 'Aktif') {
                $status = $user->status;

                // Segera logout user yang tidak aktif agar tidak ada session yang tersisa
                Auth::guard('sales')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Siapkan pesan error spesifik berdasarkan status akun
                $errorMessage = 'Akun Anda belum aktif. Silakan hubungi admin.'; // Pesan default
                if ($status === 'Cuti') {
                    $errorMessage = 'Akun Anda sedang dalam masa cuti dan tidak dapat digunakan. Hubungi admin untuk informasi lebih lanjut.';
                } elseif ($status === 'Nonaktif') {
                    $errorMessage = 'Akun Anda telah dinonaktifkan. Silakan hubungi admin untuk informasi lebih lanjut.';
                }

                // Kembalikan ke halaman login dengan pesan error yang jelas
                return redirect()->route('sales.login')
                    ->withInput($request->only('email', 'remember'))
                    ->with('error', $errorMessage);
            }

            // 4. Jika status 'Aktif', regenerasi session dan lanjutkan ke dashboard
            $request->session()->regenerate();
            return redirect()->intended(route('sales.dashboard'));
        }

        // 5. Jika kredensial salah, kembali dengan pesan error umum
        return redirect()->route('sales.login')
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }

    /**
     * Melakukan logout pada sales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('sales')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/sales/login');
    }
}
