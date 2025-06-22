<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Sales - KulakanCepat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        .login-background {
            background-color: #f7fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ef4444' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
        }
    </style>
</head>

<body class="font-sans antialiased login-background">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-md">
            <div class="text-center mb-6">
                <a href="#" class="inline-flex items-center justify-center gap-3">
                    <img src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}" alt="Logo KulakanCepat"
                        class="h-12 w-auto" />
                    <span class="text-3xl font-extrabold text-gray-800 tracking-tight">KulakanCepat</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 border border-gray-200/50">
                <div class="text-left mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Selamat Datang!</h1>
                    <p class="text-gray-500 text-sm">Silakan masuk untuk mengakses portal sales.</p>
                </div>

                <form method="POST" action="{{ route('sales.login') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 text-sm rounded-md"
                            role="alert">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <a href="#" class="font-medium text-red-600 hover:text-red-500">
                            Lupa password?
                        </a>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-transform transform hover:scale-105">
                            Login
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? <a href="#"
                                class="font-semibold text-red-600 hover:underline">Hubungi Admin</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
