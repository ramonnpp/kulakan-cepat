<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lengkapi Pendaftaran - KulakanCepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body
    class="flex min-h-screen items-center justify-center bg-gradient-to-b from-[#B8182D] to-[#520B14] py-8">
    <div class="flex min-h-screen w-full">
      <div class="hidden w-1/2 flex-col justify-center pl-20 text-white md:flex">
        <div class="mb-2 flex items-center gap-4">
          <img
            src="{{ asset('img/Logo Kulakan/1x/Artboard 1 copy 3.png') }}"
            alt="Logo"
            class="h-60 w-60" />
          <h1 class="text-5xl font-semibold">KulakanCepat</h1>
        </div>
        <p class="text-5xl font-bold leading-tight">
          Solusi mudah untuk
          <br />
          belanja grosir
        </p>
      </div>
      <div class="flex w-full items-center justify-center p-4 sm:p-20 md:w-1/2">
        <form
          method="POST"
          action="{{ route('google.register.process') }}"
          class="w-full max-w-md rounded-xl bg-white p-8 text-center shadow-lg">
          @csrf
          <h2 class="mb-2 text-2xl font-semibold text-gray-800">Lengkapi Pendaftaran</h2>
          <p class="mb-6 text-sm text-gray-500">Nama dan email Anda diambil dari Google.</p>

          @if ($errors->any())
            <div
              class="mb-4 border-l-4 border-red-500 bg-red-100 p-4 text-left text-sm text-red-700"
              role="alert">
              <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-4">
            <input
              type="text"
              name="name_store"
              placeholder="Nama Toko Anda"
              value="{{ old('name_store') }}"
              required
              class="w-full rounded-md border border-red-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="name_owner"
              placeholder="Nama Anda"
              value="{{ session('google_user_data')->getName() }}"
              readonly
              class="w-full rounded-md border border-red-300 bg-gray-100 p-2 text-sm" />
          </div>
          <div class="mb-4">
            <input
              type="email"
              name="email"
              placeholder="Email"
              value="{{ session('google_user_data')->getEmail() }}"
              readonly
              class="w-full rounded-md border border-red-300 bg-gray-100 p-2 text-sm" />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="no_phone"
              placeholder="No telepon"
              value="{{ old('no_phone') }}"
              required
              class="w-full rounded-md border border-red-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="address"
              placeholder="Alamat Toko"
              value="{{ old('address') }}"
              required
              class="w-full rounded-md border border-red-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
          </div>

          <button
            type="submit"
            class="w-full rounded-md bg-[#B8182D] py-2 text-base font-medium text-white transition hover:bg-[#520B14]">
            Selesaikan Pendaftaran
          </button>
        </form>
      </div>
    </div>
  </body>
</html>
