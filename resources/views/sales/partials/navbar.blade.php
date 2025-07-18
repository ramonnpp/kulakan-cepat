<header
    class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            <div class="flex items-center space-x-3">
                <button id="sidebar-toggle" class="lg:hidden text-gray-500 hover:text-gray-600" aria-controls="sidebar"
                    aria-expanded="false">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2"></rect>
                        <rect x="4" y="11" width="16" height="2"></rect>
                        <rect x="4" y="17" width="16" height="2"></rect>
                    </svg>
                </button>

            </div>

            <div class="flex items-center space-x-4">

                <div class="relative">
                    <button id="notification-button"
                        class="relative w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-200">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                        <div
                            class="absolute top-0 right-0 -mt-1 -mr-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center border-2 border-white dark:border-gray-800 animate-pulse">
                            <span class="text-xs font-bold text-white">3</span>
                        </div>
                    </button>

                    <div id="notification-dropdown"
                        class="origin-top-right absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl overflow-hidden z-20 hidden animate-fade-in-down">
                        <div
                            class="py-3 px-4 font-bold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700">
                            Notifikasi
                        </div>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-80 overflow-y-auto">
                            <li
                                class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 cursor-pointer">
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-10 h-10 bg-green-100 dark:bg-green-800/50 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100">Pesanan baru
                                            #12345 telah diterima.</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">5 menit lalu</p>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 cursor-pointer">
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-10 h-10 bg-yellow-100 dark:bg-yellow-800/50 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 2.98-1.742 2.98H4.42c-1.532 0-2.492-1.646-1.742-2.98l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100">Stok produk
                                            hampir habis: Teh Botol.</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">1 jam lalu</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div
                            class="py-2 px-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 text-center">
                            <a href="#"
                                class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Lihat semua
                                notifikasi</a>
                        </div>
                    </div>
                </div>

                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700"></div>

                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-3 group" aria-expanded="false">
                        @php
                            $sales = Auth::guard('sales')->user();
                        @endphp
                        @if ($sales && $sales->foto_profil)
                            <img class="h-8 w-8 rounded-full object-cover"
                                src="{{ asset('storage/' . $sales->foto_profil) }}" alt="User profile">
                        @else
                            {{-- Fallback/Default avatar jika tidak ada foto --}}
                            <span class="inline-block h-8 w-8 overflow-hidden rounded-full bg-gray-100">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                        @endif
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                                {{ Auth::guard('sales')->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sales</p>
                        </div>
                    </button>

                    <div id="user-dropdown"
                        class="origin-top-right absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl overflow-hidden z-20 hidden animate-fade-in-down">
                        <div class="pt-3 pb-2 px-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="font-semibold text-gray-800 dark:text-gray-100">
                                {{ Auth::guard('sales')->user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ Auth::guard('sales')->user()->email }}</div>
                        </div>
                        <ul class="py-1">
                            <li>
                                {{-- --- PERBAIKAN DI SINI --- --}}
                                <a href="{{ route('sales.profile.show') }}"
                                    class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span>Profil Saya</span>
                                </a>
                            </li>
                            <li class="border-t border-gray-200 dark:border-gray-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('sales.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center space-x-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Tambahkan Style untuk Animasi --}}
<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.2s ease-out;
    }
</style>


<script>
    // Script untuk toggle dropdowns (sebagian besar sama, hanya disederhanakan)
    document.addEventListener('DOMContentLoaded', function() {
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        const setupDropdown = (button, dropdown) => {
            if (!button || !dropdown) return;
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                // Sembunyikan dropdown lain sebelum menampilkan yang ini
                if (dropdown === notificationDropdown) userDropdown.classList.add('hidden');
                if (dropdown === userDropdown) notificationDropdown.classList.add('hidden');

                dropdown.classList.toggle('hidden');
            });
        };

        setupDropdown(notificationButton, notificationDropdown);
        setupDropdown(userMenuButton, userDropdown);

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', (e) => {
            if (notificationDropdown && !notificationDropdown.contains(e.target) && !notificationButton
                .contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
            if (userDropdown && !userDropdown.contains(e.target) && !userMenuButton.contains(e
                    .target)) {
                userDropdown.classList.add('hidden');
            }
        });

        // Script untuk toggle sidebar mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    });
</script>
