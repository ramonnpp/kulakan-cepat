<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun Sales - Kulakan Cepat</title>
    @vite('resources/css/app.css')
    {{-- Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        /* Menambahkan pola titik-titik halus sebagai latar belakang */
        .pattern-bg {
            background-image: radial-gradient(#d1d5db 0.5px, transparent 0.5px);
            background-size: 15px 15px;
        }
    </style>
</head>

<body class="h-full bg-gray-100">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-4xl">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    {{-- Bagian Kiri: Formulir Pendaftaran --}}
                    <div class="p-8 md:p-12">
                        <div class="sm:mx-auto sm:w-full sm:max-w-md">
                            <a href="#">
                                <img class="mx-auto h-16 w-auto"
                                    src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}"
                                    alt="Logo KulakanCepat" />
                            </a>
                            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                                Buat Akun Sales
                            </h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                                Sudah punya akun?
                                <a href="{{ route('sales.login') }}"
                                    class="font-semibold text-red-600 hover:text-red-500">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>

                        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                            <form class="space-y-4" action="{{ route('sales.register.submit') }}" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded-md text-sm"
                                        role="alert">
                                        <ul class="list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Input dengan ikon --}}
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <input id="name" name="name" type="text" placeholder="Nama Lengkap"
                                        value="{{ old('name') }}" required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                </div>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-envelope text-gray-400"></i>
                                    </div>
                                    <input id="email" name="email" type="email" placeholder="Alamat Email"
                                        value="{{ old('email') }}" required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                </div>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-phone text-gray-400"></i>
                                    </div>
                                    <input id="no_phone" name="no_phone" type="tel" placeholder="Nomor Telepon"
                                        value="{{ old('no_phone') }}" required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                </div>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-map-location-dot text-gray-400"></i>
                                    </div>
                                    <input id="wilayah" name="wilayah" type="text"
                                        placeholder="Wilayah Kerja (Contoh: Yogyakarta)" value="{{ old('wilayah') }}"
                                        required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                </div>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-lock text-gray-400"></i>
                                    </div>
                                    <input id="password" name="password" type="password" placeholder="Password"
                                        required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                    <button type="button" data-toggle="password"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                                        <i class="fa-solid fa-eye-slash text-gray-400"></i>
                                    </button>
                                </div>

                                {{-- Kolom Konfirmasi Password dengan Fitur Tampilkan/Sembunyikan --}}
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-lock text-gray-400"></i>
                                    </div>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        placeholder="Konfirmasi Password" required
                                        class="block w-full rounded-md border-0 py-2.5 pl-10 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm">
                                    <button type="button" data-toggle="password"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                                        <i class="fa-solid fa-eye-slash text-gray-400"></i>
                                    </button>
                                </div>
                                <div class="pt-2">
                                    <button type="submit"
                                        class="flex w-full justify-center rounded-md bg-red-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                        Daftar Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Bagian Kanan: Gambar Dekoratif --}}
                    <div class="hidden md:block relative">
                        <div class="absolute inset-0 bg-red-600 opacity-90"></div>
                        <div class="absolute inset-0 pattern-bg opacity-20"></div>
                        <img class="object-cover h-full w-full"
                            src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                            alt="Sales Team">
                        <div
                            class="absolute inset-0 flex flex-col justify-center items-center text-white p-10 text-center">
                            <h3 class="text-3xl font-bold tracking-wider">Bergabunglah Bersama Kami</h3>
                            <p class="mt-4 text-lg font-light">Jadilah bagian dari tim penjualan terbaik dan raih
                                kesuksesan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.querySelectorAll('[data-toggle="password"]').forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const eyeIcon = this.querySelector('i');

            // toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // toggle the eye slash icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>

</html>
