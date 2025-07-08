<aside id="sidebar"
    class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-auto lg:overflow-y-auto no-scrollbar w-64 lg:w-20 xl:w-64 shrink-0 bg-gray-800 p-4 transition-all duration-300 ease-in-out -translate-x-full shadow-2xl">

    <div class="flex items-center justify-center mb-8 px-2">
        <a class="group flex items-center" href="{{ route('sales.dashboard') }}">
            <img src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}" alt="Logo Kulakan"
                class="w-12 h-auto transition-transform duration-300 group-hover:scale-110">
            <span class="ml-3 text-white text-xl font-bold lg:hidden xl:inline tracking-wider">KulakanCepat</span>
        </a>
    </div>

    <div class="space-y-2 flex-grow">
        @php
            $menuItems = [
                'sales.dashboard' => [
                    'name' => 'Dashboard',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
                ],
                'sales.scanner' => [
                    'name' => 'Scan Produk',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 9.375v-4.5zM3.75 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 19.125v-4.5zM13.5 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 9.375v-4.5zM13.5 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 19.125v-4.5z" />',
                ],
                'sales.customers.index' => [
                    'name' => 'Customers',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3M16 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                ],
                'sales.visit_schedule.index' => [
                    'name' => 'Jadwal Kunjungan',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
                ],
                'sales.performance_report' => [
                    'name' => 'Laporan Kinerja',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
                ],
                'sales.sales_material.index' => [
                    'name' => 'Materi Penjualan',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />',
                ],
            ];

            $isActive = function ($routeName) {
                // Gunakan Str::startsWith untuk menangani route resource
                // contoh: sales.customers.index, sales.customers.show, dll. akan dianggap aktif jika routeName-nya 'sales.customers.index'
                $currentRouteName = request()->route()->getName();
                $baseRoute = explode('.', $routeName)[0] . '.' . explode('.', $routeName)[1];
                return \Illuminate\Support\Str::startsWith($currentRouteName, $baseRoute);
            };
        @endphp

        @foreach ($menuItems as $route => $item)
            <a href="{{ route($route) }}"
                class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg relative
                {{ $isActive($route) ? 'bg-gradient-to-r from-red-600 to-red-800 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
                transition-all duration-200">
                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    {!! $item['icon'] !!}
                </svg>
                <span class="ml-4 lg:hidden xl:inline">{{ $item['name'] }}</span>
                @if ($isActive($route))
                    <div class="absolute right-0 h-full w-1 bg-white rounded-l-full"></div>
                @endif
            </a>
        @endforeach
    </div>

    {{-- <div class="mt-auto">
        <form method="POST" action="{{ route('sales.logout') }}">
            @csrf
            <button type="submit"
                class="group w-full flex items-center px-3 py-3 text-sm font-medium rounded-lg text-gray-400 hover:bg-red-800/50 hover:text-white transition-all duration-200">
                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="ml-4 lg:hidden xl:inline">Logout</span>
            </button>
        </form>
    </div> --}}
</aside>
