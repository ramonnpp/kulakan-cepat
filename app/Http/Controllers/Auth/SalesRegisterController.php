<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SalesRegisterController extends Controller
{
    /**
     * Menampilkan form registrasi untuk sales.
     */
    public function showRegistrationForm()
    {
        return view('sales.auth.register');
    }

    /**
     * Menangani permintaan registrasi sales.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        Sales::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_phone' => $request->no_phone,
            'password' => $request->password, // Mutator di model akan melakukan hashing
            'status' => 'Nonaktif', // Status awal saat mendaftar
            'wilayah' => $request->wilayah,
        ]);

        // Arahkan ke halaman "menunggu konfirmasi"
        return redirect()->route('sales.pending');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sales'],
            'no_phone' => ['required', 'string', 'max:20'],
            'wilayah' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
