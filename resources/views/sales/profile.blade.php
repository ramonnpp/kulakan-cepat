@extends('sales.layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Profil Saya</h1>


    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
            <p class="font-bold">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Foto & Info Singkat --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md text-center">
                <img class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-red-500 shadow-lg" src="https://ui-avatars.com/api/?name={{ urlencode($sales->name) }}&size=128&background=b91c1c&color=ffffff&bold=true" alt="Foto Profil">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $sales->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Sales Representative</p>
                <div class="mt-6 text-left space-y-3 text-gray-600 dark:text-gray-300 text-sm">
                    <p class="flex items-center"><i class="fas fa-envelope fa-fw mr-3 text-red-500"></i><span>{{ $sales->email }}</span></p>
                    <p class="flex items-center"><i class="fas fa-phone-alt fa-fw mr-3 text-red-500"></i><span>{{ $sales->no_phone }}</span></p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Edit --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <form action="{{ route('sales.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        {{-- Informasi Personal --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">Informasi Personal</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $sales->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $sales->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="no_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                                    <input type="text" name="no_phone" id="no_phone" value="{{ old('no_phone', $sales->no_phone) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        {{-- Ganti Password --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">Ganti Password</h3>
                             <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection