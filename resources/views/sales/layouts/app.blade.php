<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KulakanCepat - Sales</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    {{-- Memastikan div utama yang membungkus layout memiliki z-index yang lebih tinggi --}}
    <div class="flex h-screen overflow-hidden content-wrapper">
        @include('sales.partials.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            @include('sales.partials.navbar')

            <main class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 leading-normal text-green-800 bg-green-100 dark:text-green-100 dark:bg-green-900/50 rounded-lg border border-green-200 dark:border-green-700"
                        role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 px-4 py-3 leading-normal text-red-800 bg-red-100 dark:text-red-100 dark:bg-red-900/50 rounded-lg border border-red-200 dark:border-red-700"
                        role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-medium text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> {{-- Pastikan Chart.js dimuat sebelum adapternya --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script>
    @stack('scripts')
</body>

</html>
