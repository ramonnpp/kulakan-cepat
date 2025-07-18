<header
    class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            <div class="flex items-center space-x-3">
                <button id="sidebar-toggle" class="lg:hidden text-gray-500 hover:text-gray-600" aria-controls="sidebar"
                    aria-expanded="false">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="4" x2="20" y1="6" y2="6" />
                        <line x1="4" x2="20" y1="18" y2="18" />
                    </svg>
                </button>
            </div>

            <div class="hidden lg:flex flex-1 mx-8 items-center justify-center">
                <div
                    class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-inner w-full max-w-xl">
                    {{-- Bagian Kiri: Sapaan (Lebar Otomatis) --}}
                    <div id="greeting-container"
                        class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 px-3 flex-shrink-0">
                        <span id="greeting-icon" class="text-xl"></span>
                        <div>
                            <span id="greeting-text" class="font-semibold text-sm"></span>
                            <span
                                class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ Auth::guard('sales')->user()->name }}</span>
                        </div>
                    </div>

                    {{-- Bagian Kanan: Tanggal & Waktu --}}
                    <div id="date-and-time" class="flex items-center justify-end space-x-3 px-3">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                        <span id="date-display"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-200 whitespace-nowrap"></span>
                        <span class="text-gray-400 dark:text-gray-600">|</span>
                        <span id="clock"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-200 whitespace-nowrap"></span>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-3 group" aria-expanded="false">
                        @php
                            $sales = Auth::guard('sales')->user();
                        @endphp
                        @if ($sales && $sales->foto_profil)
                            <img class="h-9 w-9 rounded-full object-cover ring-2 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 ring-blue-500"
                                src="{{ asset('storage/' . $sales->foto_profil) }}" alt="User profile">
                        @else
                            <span
                                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-500 ring-2 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 ring-blue-500">
                                <span
                                    class="font-medium leading-none text-white">{{ strtoupper(substr($sales->name, 0, 2)) }}</span>
                            </span>
                        @endif
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                                {{ $sales->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sales</p>
                        </div>
                    </button>

                    <div id="user-dropdown"
                        class="origin-top-right absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl overflow-hidden z-20 hidden animate-fade-in-down">
                        <div class="pt-3 pb-2 px-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="font-semibold text-gray-800 dark:text-gray-100">
                                {{ $sales->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $sales->email }}</div>
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('sales.profile.show') }}"
                                    class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span>Profil Saya</span>
                                </a>
                            </li>
                            <li class="border-t border-gray-200 dark:border-gray-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('sales.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center space-x-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" x2="9" y1="12" y2="12" />
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
    document.addEventListener('DOMContentLoaded', function() {
        // --- Jam, Tanggal, & Sapaan ---
        const clockElement = document.getElementById('clock');
        const greetingTextElement = document.getElementById('greeting-text');
        const greetingIconElement = document.getElementById('greeting-icon');
        const dateDisplayElement = document.getElementById('date-display');

        const updateTimeElements = () => {
            const now = new Date();
            const hours = now.getHours();

            if (clockElement) {
                clockElement.textContent = now.toLocaleTimeString('id-ID', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }

            if (dateDisplayElement) {
                dateDisplayElement.textContent = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            let greeting = "Halo,";
            let icon = "👋";
            if (hours >= 4 && hours < 11) {
                greeting = "Selamat Pagi,";
                icon = "☀️";
            } else if (hours >= 11 && hours < 15) {
                greeting = "Selamat Siang,";
                icon = "☀️";
            } else if (hours >= 15 && hours < 19) {
                greeting = "Selamat Sore,";
                icon = "🌥️";
            } else {
                greeting = "Selamat Malam,";
                icon = "🌙";
            }

            if (greetingTextElement) greetingTextElement.textContent = greeting;
            if (greetingIconElement) greetingIconElement.textContent = icon;
        };

        updateTimeElements();
        setInterval(updateTimeElements, 1000);

        // --- Logika Dropdown & Sidebar ---
        const setupDropdown = (button, dropdown) => {
            if (!button || !dropdown) return;
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });
        };

        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        setupDropdown(userMenuButton, userDropdown);

        document.addEventListener('click', (e) => {
            if (userDropdown && !userDropdown.contains(e.target) && !userMenuButton.contains(e
                .target)) {
                userDropdown.classList.add('hidden');
            }
        });

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
