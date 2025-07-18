<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // <-- PASTIKAN INI DI-IMPORT

class SalesRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('sales.auth.register');
    }

    public function register(Request $request)
    {
        // Jalankan validasi
        $this->validator($request->all())->validate();

        // Proses unggah file foto
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            // Simpan file di dalam folder 'storage/app/public/sales_profiles'
            // dan buat symbolic link jika belum ada dengan 'php artisan storage:link'
            $fotoPath = $request->file('foto_profil')->store('sales_profiles', 'public');
        }

        // Buat data sales baru
        Sales::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_phone' => $request->no_phone,
            'password' => $request->password, // Password sudah di-hash oleh mutator di model
            'status' => 'Nonaktif',
            'wilayah' => $request->wilayah,
            'foto_profil' => $fotoPath, // Simpan path foto ke database
        ]);

        return redirect()->route('sales.pending')->with('status', 'Registrasi berhasil! Mohon tunggu konfirmasi dari admin.');
    }

    protected function validator(array $data)
    {
        // Tambahkan aturan validasi untuk foto_profil
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sales'],
            'no_phone' => ['required', 'string', 'max:20', 'regex:/^08[0-9]{8,11}$/'],
            'wilayah' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'foto_profil' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // <-- TAMBAHKAN VALIDASI INI
        ]);
    }
}
