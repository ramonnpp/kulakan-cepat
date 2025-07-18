@extends('sales.layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Profil Saya</h1>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Foto & Info Singkat --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center flex flex-col items-center">
                    {{-- Foto Profil --}}
                    <div class="relative">
                        @if ($sales->foto_profil)
                            <img class="h-40 w-40 rounded-full object-cover ring-4 ring-red-500 p-1"
                                src="{{ asset('storage/' . $sales->foto_profil) }}" alt="Foto Profil {{ $sales->name }}">
                        @else
                            {{-- Fallback jika tidak ada foto --}}
                            <span
                                class="inline-block h-40 w-40 overflow-hidden rounded-full bg-gray-200 ring-4 ring-red-500 p-1">
                                <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                        @endif
                    </div>

                    {{-- Tombol Ganti Foto --}}
                    <form action="{{ route('sales.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data"
                        class="mt-4">
                        @csrf
                        <label for="foto_profil_upload"
                            class="cursor-pointer bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold py-2 px-4 rounded-full">
                            Ganti Foto
                        </label>
                        <input type="file" name="foto_profil" id="foto_profil_upload" class="hidden"
                            onchange="this.form.submit()">
                    </form>

                    {{-- Info Sales --}}
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">{{ $sales->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sales Representative</p>

                    <div class="mt-6 w-full text-left space-y-3 text-gray-600 dark:text-gray-300 text-sm">
                        <p class="flex items-center"><i
                                class="fas fa-envelope fa-fw mr-3 text-red-500"></i><span>{{ $sales->email }}</span></p>
                        <p class="flex items-center"><i
                                class="fas fa-phone-alt fa-fw mr-3 text-red-500"></i><span>{{ $sales->no_phone }}</span></p>
                        <p class="flex items-center"><i
                                class="fas fa-map-marker-alt fa-fw mr-3 text-red-500"></i><span>{{ $sales->wilayah }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Edit --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <form action="{{ route('sales.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            {{-- Informasi Personal --}}
                            <div>
                                <h3
                                    class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                                    Informasi Personal
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                            Lengkap</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $sales->name) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat
                                            Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $sales->email) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="no_phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                            Telepon</label>
                                        <input type="text" name="no_phone" id="no_phone"
                                            value="{{ old('no_phone', $sales->no_phone) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-red-500 focus:ring-red-500">
                                    </div>
                                </div>
                            </div>

                            {{-- Ganti Password --}}
                            <div>
                                <h3
                                    class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                                    Ganti Password
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Kosongkan jika tidak ingin mengubah
                                    password.</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password
                                            Baru</label>
                                        <input type="password" name="password" id="password"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-red-500 focus:ring-red-500">
                                    </div>
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi
                                            Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-red-500 focus:ring-red-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
