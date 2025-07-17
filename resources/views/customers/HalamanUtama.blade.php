@extends('layouts.app')

@section('title', 'KulakanCepat.id - Platform Grosir Digital Modern')

@section('content')
  <main class="bg-white">
    <section class="relative overflow-hidden bg-gradient-to-r from-red-200 from-10% via-red-100 via-30% to-red-200 to-90%">
      <div class="mx-auto max-w-7xl">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:w-full lg:max-w-2xl lg:pb-28 xl:pb-32">
          <svg
            class="absolute inset-y-0 right-0 hidden h-full w-48 translate-x-1/2 transform text-gray-50 lg:block"
            fill="currentColor"
            viewBox="0 0 100 100"
            preserveAspectRatio="none"
            aria-hidden="true">
            <polygon points="50,0 100,0 50,100 0,100" />
          </svg>
          <div class="relative px-4 pt-6 sm:px-6 lg:px-8"></div>
          <div
            class="mx-auto mt-10 max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
            <div class="sm:text-center lg:text-left">
              <!-- Promo Badge -->
              <a
                href="{{ route('catalog.index') }}"
                class="group inline-flex items-center space-x-6">
                <span
                  class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-semibold text-red-700">
                  🎉 Promo Merdeka!
                </span>
                <span class="inline-flex items-center text-sm font-medium text-red-600">
                  Lihat semua diskon
                  <span class="ml-1 transition-transform group-hover:translate-x-1">&rarr;</span>
                </span>
              </a>

              <!-- Main Headline -->
              <h1
                class="mt-4 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block">Grosir Digital</span>
                <span class="block text-red-600">Untuk Usaha Anda</span>
              </h1>
              <p
                class="mt-3 text-base text-gray-500 sm:mx-auto sm:mt-5 sm:max-w-xl sm:text-lg md:mt-5 md:text-xl lg:mx-0">
                Temukan semua kebutuhan bisnis Anda dengan harga terbaik, kualitas terjamin, dan
                pengiriman super cepat.
              </p>

              <!-- CTA Buttons -->
              <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                  <a
                    href="{{ route('catalog.index') }}"
                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-red-600 px-8 py-3 text-base font-medium text-white transition-colors hover:bg-red-700 md:px-10 md:py-4 md:text-lg">
                    Mulai Belanja
                  </a>
                </div>
                <div class="mt-3 sm:ml-3 sm:mt-0">
                  <a
                    href="#"
                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-white px-8 py-3 text-base font-medium text-red-700 transition-colors hover:bg-red-200 md:px-10 md:py-4 md:text-lg">
                    Cara Kerja
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img
          class="h-56 w-full object-cover sm:h-72 md:h-96 lg:h-full lg:w-full"
          src="{{ asset('img/logo/gambar1.jpg') }}"
          alt="Suasana toko kelontong yang ramai" />
      </div>
    </section>

    <section class="bg-white py-16 sm:py-24">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-base font-semibold uppercase tracking-wider text-red-600">
            Kategori Populer
          </h2>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6">
          @foreach ($categories as $category)
            <a
              href="{{ route('catalog.index', ['category' => $category->id_product_category]) }}"
              class="group block text-center">
              <div class="relative mx-auto flex h-24 w-24 items-center justify-center">
                <div
                  class="absolute h-full w-full rounded-full bg-gray-100 transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:bg-red-100"></div>

                <i
                  class="{{ $category->icon ?? 'fas fa-box' }} relative z-10 text-3xl text-gray-600 transition-colors duration-300 group-hover:text-red-600"></i>
              </div>
              <h3
                class="mt-4 text-base font-semibold text-gray-800 transition-colors duration-300 group-hover:text-red-600">
                {{ $category->name }}
              </h3>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <section class="bg-white py-16 sm:py-24">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Tab Headers -->
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button
              id="tab-terlaris"
              role="tab"
              aria-controls="panel-terlaris"
              aria-selected="true"
              class="tab-button whitespace-nowrap border-b-2 border-red-600 px-1 py-4 text-base font-medium text-red-600">
              Produk Terlaris
            </button>
            <button
              id="tab-terbaru"
              role="tab"
              aria-controls="panel-terbaru"
              aria-selected="false"
              class="tab-button whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
              Produk Terbaru
            </button>
          </nav>
        </div>

        <!-- Tab Panels -->
        <div class="mt-8">
          <!-- Best Selling Panel -->
          <div id="panel-terlaris" role="tabpanel" aria-labelledby="tab-terlaris">
            <div
              class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:gap-x-6">
              @forelse ($bestSellingProducts->take(12) as $product)
                {{-- Kartu Produk dengan Font Disesuaikan dan Path Gambar Diperbaiki --}}
                <div
                  class="card-hover product-card flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg">
                  {{-- <a
                    href="{{ route('produk.show', $product->id_product) }}"
                    class="card-hover product-card group flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg"> --}}
                    <div class="flex h-40 items-center justify-center overflow-hidden bg-gray-100">
                      <img
                        src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/300x200/e2e8f0/94a3b8?text=Gambar' }}"
                        alt="{{ $product->name_product }}"
                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-110" />
                    </div>
                  </a>
                  <div class="flex flex-grow flex-col p-3">
                    <h4 class="mb-2 h-10 text-sm font-bold text-gray-800">
                      {{ Str::limit($product->name_product, 45) }}
                    </h4>
                    <div class="mb-3">
                      @if ($product->total_stock > 0)
                        <span
                          class="inline-block rounded-full bg-green-200 px-2 py-1 text-xs font-semibold uppercase text-green-600">
                          Stok: {{ $product->total_stock }}
                        </span>
                      @else
                        <span
                          class="inline-block rounded-full bg-red-200 px-2 py-1 text-xs font-semibold uppercase text-red-600">
                          Stok Habis
                        </span>
                      @endif
                    </div>
                    <div class="mb-4 mt-auto">
                      <p class="text-xs text-gray-500">Harga per Kardus</p>
                      <p class="text-lg font-bold text-red-600">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                      </p>
                    </div>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                      @csrf
                      <input type="hidden" name="quantity" value="1" />
                      <button
                        type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-red-500 to-red-600 py-2 text-sm font-semibold text-white transition-all hover:from-red-600 hover:to-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                        {{ $product->total_stock <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus mr-2"></i>
                        <span>Tambah</span>
                      </button>
                    </form>
                  </div>
                </div>
              @empty
                <p class="col-span-full py-12 text-center text-gray-500">
                  Produk terlaris belum tersedia.
                </p>
              @endforelse
            </div>
            <div class="mt-12 text-center">
              <a
                href="{{ route('catalog.index', ['sort' => 'best_selling']) }}"
                class="text-base font-semibold text-red-600 transition-colors hover:text-red-800">
                Lihat Semua Produk Terlaris
                <span aria-hidden="true">&rarr;</span>
              </a>
            </div>
          </div>

          <!-- Newest Panel -->
          <div id="panel-terbaru" role="tabpanel" aria-labelledby="tab-terbaru" class="hidden">
            <div
              class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:gap-x-6">
              @forelse ($latestProducts->take(12) as $product)
                {{-- Kartu Produk dengan Font Disesuaikan dan Path Gambar Diperbaiki --}}
                <div
                  class="card-hover product-card flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg">
                  {{-- <a
                    href="{{ route('produk.show', $product->id_product) }}"
                    class="card-hover product-card group flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg"> --}}
                    <div class="flex h-40 items-center justify-center overflow-hidden bg-gray-100">
                      <img
                        src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://placehold.co/300x200/e2e8f0/94a3b8?text=Gambar' }}"
                        alt="{{ $product->name_product }}"
                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-110" />
                    </div>
                  </a>
                  <div class="flex flex-grow flex-col p-3">
                    <h4 class="mb-2 h-10 text-sm font-bold text-gray-800">
                      {{ Str::limit($product->name_product, 45) }}
                    </h4>
                    <div class="mb-3">
                      @if ($product->total_stock > 0)
                        <span
                          class="inline-block rounded-full bg-green-200 px-2 py-1 text-xs font-semibold uppercase text-green-600">
                          Stok: {{ $product->total_stock }}
                        </span>
                      @else
                        <span
                          class="inline-block rounded-full bg-red-200 px-2 py-1 text-xs font-semibold uppercase text-red-600">
                          Stok Habis
                        </span>
                      @endif
                    </div>
                    <div class="mb-4 mt-auto">
                      <p class="text-xs text-gray-500">Harga per Kardus</p>
                      <p class="text-lg font-bold text-red-600">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                      </p>
                    </div>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                      @csrf
                      <input type="hidden" name="quantity" value="1" />
                      <button
                        type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-red-500 to-red-600 py-2 text-sm font-semibold text-white transition-all hover:from-red-600 hover:to-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                        {{ $product->total_stock <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus mr-2"></i>
                        <span>Tambah</span>
                      </button>
                    </form>
                  </div>
                </div>
              @empty
                <p class="col-span-full py-12 text-center text-gray-500">
                  Produk terbaru belum tersedia.
                </p>
              @endforelse
            </div>
            <div class="mt-12 text-center">
              <a
                href="{{ route('catalog.index', ['sort' => 'latest']) }}"
                class="text-base font-semibold text-red-600 transition-colors hover:text-red-800">
                Lihat Semua Produk Terbaru
                <span aria-hidden="true">&rarr;</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection

@push('scripts')
  <script>
    // This script ensures that the tab functionality works correctly.
    document.addEventListener('DOMContentLoaded', function () {
      const tabs = document.querySelectorAll('.tab-button')
      const panels = document.querySelectorAll('[role="tabpanel"]')

      tabs.forEach((tab) => {
        tab.addEventListener('click', (e) => {
          e.preventDefault()
          const targetPanelId = tab.getAttribute('aria-controls')

          // Deactivate all tabs
          tabs.forEach((t) => {
            t.setAttribute('aria-selected', 'false')
            t.classList.remove('border-red-600', 'text-red-600')
            t.classList.add(
              'border-transparent',
              'text-gray-500',
              'hover:text-gray-700',
              'hover:border-gray-300',
            )
          })

          // Activate the clicked tab
          tab.setAttribute('aria-selected', 'true')
          tab.classList.add('border-red-600', 'text-red-600')
          tab.classList.remove(
            'border-transparent',
            'text-gray-500',
            'hover:text-gray-700',
            'hover:border-gray-300',
          )

          // Hide all panels
          panels.forEach((panel) => {
            panel.classList.add('hidden')
          })

          // Show the target panel
          const targetPanel = document.getElementById(targetPanelId)
          if (targetPanel) {
            targetPanel.classList.remove('hidden')
          }
        })
      })
    })
  </script>
@endpush
