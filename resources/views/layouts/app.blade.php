<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'KulakanCepat')</title>

    {{-- Aset Global --}}
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Style kustom --}}
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
      body {
        font-family: 'Inter', sans-serif;
      }
      .gradient-bg {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      }
      .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border-left-color: #fff;
        animation: spin 1s ease infinite;
      }
      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
    </style>

    @stack('styles')
  </head>
  <body class="bg-gray-100 text-gray-800">
    <!-- Header Terpadu -->
    <header class="sticky top-0 z-50 bg-white text-gray-800 shadow-lg">
      <!-- Top Bar -->
      <div class="gradient-bg text-xs text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-1 sm:px-6 lg:px-8">
          <div class="flex items-center space-x-4">
            <span>Ikuti kami di:</span>
            <a href="#" class="hover:text-red-200"><i class="fab fa-facebook"></i></a>
            <a href="#" class="hover:text-red-200"><i class="fab fa-instagram"></i></a>
          </div>
          <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="hover:text-red-200">
              <i class="fas fa-home mr-1"></i>
              Home
            </a>
            <a href="#" class="hover:text-red-200">
              <i class="fas fa-bell mr-1"></i>
              Notifikasi
            </a>
          </div>
        </div>
      </div>

      <!-- Main Header -->
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <a href="javascript:void(0)" class="flex items-center space-x-3 cursor-default select-none">
              <div class="h-12 w-12 overflow-hidden rounded-xl">
                <img
                  src="{{ asset('img/logo/Artboard 1 copy.png') }}"
                  alt="Logo KulakanCepat"
                  class="h-full w-full object-cover" />
              </div>
              <div>
                <h1 class="text-xl font-bold text-red-700">KulakanCepat</h1>
                <p class="text-xs text-gray-500">Grosir Digital</p>
              </div>
            </a>
          </div>

          <!-- Search Bar -->
          <div class="mx-8 hidden max-w-lg flex-1 md:flex">
            <form action="{{ route('catalog.index') }}" method="GET" class="relative w-full">
              <input
                name="search"
                type="text"
                placeholder="Cari di KulakanCepat"
                value="{{ request('search') }}"
                class="w-full rounded-full border-2 border-gray-200 bg-gray-100 py-3 pl-12 pr-4 text-gray-800 placeholder-gray-400 transition-all focus:border-transparent focus:outline-none focus:ring-2 focus:ring-red-500" />
              <button
                type="submit"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600">
                <i class="fas fa-search"></i>
              </button>
            </form>
          </div>

          <!-- Navigation Icons & Profile -->
          <nav class="flex items-center space-x-6">
            <a
              href="{{ route('cart.index') }}"
              class="relative text-gray-600 transition-colors hover:text-red-700">
              <i class="fas fa-shopping-cart text-2xl"></i>
              @if (session('cart') && count(session('cart')) > 0)
                <span
                  class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">
                  {{ count(session('cart')) }}
                </span>
              @endif
            </a>

            @auth('customer')
              <div x-data="{ open: false }" class="relative">
                <button
    @click="open = !open"
    class="flex cursor-pointer items-center space-x-2 rounded-full bg-gray-100 py-1 pl-1 pr-4 transition-colors hover:bg-gray-200 focus:outline-none">
    {{-- LOGIKA BARU UNTUK FOTO PROFIL --}}
    <img
        src="{{ Auth::guard('customer')->user()->avatar ? asset('storage/' . Auth::guard('customer')->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::guard('customer')->user()->name_owner) . '&background=b91c1c&color=ffffff&bold=true' }}"
        alt="Foto Profil"
        class="h-9 w-9 rounded-full object-cover" />
    
    <span class="hidden text-sm font-medium lg:block">
        {{ Str::words(Auth::guard('customer')->user()->name_owner, 2, '') }}
    </span>
</button>
                <div
                  x-show="open"
                  @click.away="open = false"
                  x-transition
                  class="absolute right-0 z-20 mt-2 w-56 rounded-xl bg-white py-2 text-sm text-gray-800 shadow-lg">
                  <div class="border-b px-4 py-3">
                    <p class="font-semibold">
                      Hi, {{ Auth::guard('customer')->user()->name_owner }}
                    </p>
                    <p class="text-xs text-gray-500">
                      {{ Auth::guard('customer')->user()->email }}
                    </p>
                  </div>
                  <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">
                    Profil Saya
                  </a>
                  <a
                    href="{{ route('profile.show', ['status' => 'semua']) }}"
                    class="block px-4 py-2 hover:bg-gray-100">
                    Riwayat Pesanan
                  </a>
                  <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block w-full px-4 py-2 text-left font-semibold text-red-600 hover:bg-red-50">
                    Logout
                  </a>
                  <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="hidden">
                    @csrf
                  </form>
                </div>
              </div>
            @else
              <a
                href="{{ route('login') }}"
                class="text-sm font-medium text-gray-600 transition-colors hover:text-red-700">
                Login
              </a>
              <a
                href="{{ route('register') }}"
                class="rounded-full bg-red-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                Daftar
              </a>
            @endauth
          </nav>
        </div>
      </div>
    </header>

    {{-- Konten Utama dari Halaman Anak --}}
    <main>
      @yield('content')
    </main>

    <!-- Footer Konsisten -->
   <footer class="bg-gray-900 text-gray-300 py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Kolom KulakanCepat -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">KulakanCepat</h3>
                <p class="text-sm">Platform grosir digital terdepan yang menghubungkan merchant dengan toko retail di seluruh Indonesia.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Kolom Produk -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Produk</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/produk/untuk-merchant') }}" class="hover:underline">Untuk Merchant</a></li>
                    <li><a href="{{ url('/produk/untuk-toko') }}" class="hover:underline">Untuk Toko</a></li>
                    <li><a href="{{ url('/produk/sistem-pembayaran') }}" class="hover:underline">Sistem Pembayaran</a></li>
                    <li><a href="{{ url('/produk/logistik') }}" class="hover:underline">Logistik</a></li>
                </ul>
            </div>

            <!-- Kolom Perusahaan -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Perusahaan</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/perusahaan/tentang-kami') }}" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="{{ url('/perusahaan/karir') }}" class="hover:underline">Karir</a></li>
                    <li><a href="{{ url('/perusahaan/blog') }}" class="hover:underline">Blog</a></li>
                    <li><a href="{{ url('/perusahaan/press-release') }}" class="hover:underline">Press Release</a></li>
                </ul>
            </div>

            <!-- Kolom Dukungan -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Dukungan</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/dukungan/pusat-bantuan') }}" class="hover:underline">Pusat Bantuan</a></li>
                    <li><a href="{{ url('/dukungan/syarat-ketentuan') }}" class="hover:underline">Syarat & Ketentuan</a></li>
                    <li><a href="{{ url('/dukungan/kebijakan-privasi') }}" class="hover:underline">Kebijakan Privasi</a></li>
                    <li><a href="{{ url('/dukungan/kontak') }}" class="hover:underline">Kontak</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
            &copy; {{ date('Y') }} KulakanCepat. All rights reserved. Universitas Amikom Yogyakarta. Kampus Tercintah.
        </div>
    </div>
</footer>
    @stack('scripts')
  </body>
</html>
