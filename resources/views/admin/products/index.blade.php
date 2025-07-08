@extends("admin.layouts.app")

@section("title", "Manajemen Produk")

@section("content")
  <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    {{-- Header Halaman --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Manajemen Produk</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
          Kelola semua produk dalam inventaris Anda.
        </p>
      </div>
      <div class="mt-4 sm:mt-0">
        <a
          href="{{ route("admin.products.create") }}"
          class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-800/50 focus:ring-offset-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
              clip-rule="evenodd" />
          </svg>
          <span>Tambah Produk</span>
        </a>
      </div>
    </div>

    {{-- Filter --}}
    <div
      class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-md dark:border-slate-800 dark:bg-slate-800/50">
      <form action="{{ route("admin.products.index") }}" method="GET" id="filterForm">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <div>
            <label
              for="search_product"
              class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
              Cari Produk
            </label>
            <input
              type="text"
              name="search_product"
              id="search_product"
              value="{{ request("search_product") }}"
              class="focus:ring-primary/50 focus:border-primary/50 w-full rounded-lg border-slate-300 px-3 py-2 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
              placeholder="Nama atau SKU..." />
          </div>
          <div>
            <label
              for="id_product_category"
              class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
              Kategori
            </label>
            <select
              id="id_product_category"
              name="id_product_category"
              class="focus:ring-primary/50 focus:border-primary/50 w-full rounded-lg border-slate-300 px-3 py-2 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300"
              onchange="submitFilter()">
              <option value="">Semua Kategori</option>
              @foreach ($categories ?? [] as $category)
                <option
                  value="{{ $category->id_product_category }}"
                  {{ request("id_product_category") == $category->id_product_category ? "selected" : "" }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </form>
    </div>

    @if (session("success"))
      <div
        class="mb-4 rounded-lg bg-green-100 px-4 py-3 leading-normal text-green-700 dark:bg-green-700/30 dark:text-green-100"
        role="alert">
        <p>{{ session("success") }}</p>
      </div>
    @endif

    <div
      class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-md dark:border-slate-800 dark:bg-slate-800/50">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead
            class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
            <tr>
              <th class="px-5 py-3 text-left font-semibold">Produk</th>
              <th class="px-5 py-3 text-left font-semibold">SKU</th>
              <th class="px-5 py-3 text-right font-semibold">Harga</th>
              <th class="px-5 py-3 text-center font-semibold">Stok</th>
              <th class="px-5 py-3 text-left font-semibold">Kategori</th>
              <th class="px-5 py-3 text-right font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 text-sm dark:divide-slate-700">
            @forelse ($products as $product)
              <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-900/50">
                <td class="whitespace-nowrap px-5 py-4">
                  <div class="flex items-center">
                    @php
                      $imageSrc = $product->image_path
                          ? (\Illuminate\Support\Str::startsWith($product->image_path, ["http://", "https://"])
                              ? $product->image_path
                              : Storage::url($product->image_path))
                          : "https://placehold.co/60x60/E2E8F0/94A3B8?text=N/A";
                    @endphp

                    <img
                      src="{{ $imageSrc }}"
                      alt="{{ $product->name_product }}"
                      class="mr-4 h-12 w-12 rounded-md object-cover" />
                    <div>
                      <div class="font-medium text-slate-800 dark:text-slate-100">
                        {{ $product->name_product }}
                      </div>
                      <div
                        class="max-w-xs truncate text-xs text-slate-500 dark:text-slate-400"
                        title="{{ $product->description }}">
                        {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                      </div>
                    </div>
                  </div>
                </td>

                <td
                  class="whitespace-nowrap px-5 py-4 font-mono text-xs text-slate-600 dark:text-slate-300">
                  {{ $product->SKU }}
                </td>
                <td
                  class="whitespace-nowrap px-5 py-4 text-right text-slate-600 dark:text-slate-300">
                  Rp {{ number_format($product->price, 0, ",", ".") }}
                </td>
                <td class="whitespace-nowrap px-5 py-4 text-center">
                  <span
                    class="@if ($product->total_stock > 20)
                        bg-green-100
                        text-green-800
                        dark:bg-green-500/20
                        dark:text-green-400
                    @elseif ($product->total_stock > 0)
                        bg-yellow-100
                        text-yellow-800
                        dark:bg-yellow-500/20
                        dark:text-yellow-400
                    @else
                        bg-red-100
                        text-red-800
                        dark:bg-red-500/20
                        dark:text-red-400
                    @endif rounded-full px-2.5 py-1 text-xs font-semibold">
                    {{ $product->total_stock }}
                  </span>
                </td>
                <td class="whitespace-nowrap px-5 py-4 text-slate-600 dark:text-slate-300">
                  {{ $product->category->name ?? "-" }}
                </td>
                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                  <div class="flex items-center justify-end gap-2">
                    <a
                      href="{{ route("admin.products.edit", $product->id_product) }}"
                      class="rounded-md p-1.5 text-yellow-600 transition-colors hover:bg-yellow-100 hover:text-yellow-500 dark:text-yellow-400 dark:hover:bg-yellow-500/20 dark:hover:text-yellow-300"
                      title="Edit">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                          d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path
                          fill-rule="evenodd"
                          d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                          clip-rule="evenodd" />
                      </svg>
                    </a>
                    <form
                      action="{{ route("admin.products.destroy", $product->id_product) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                      @csrf
                      @method("DELETE")
                      <button
                        type="submit"
                        class="rounded-md p-1.5 text-red-600 transition-colors hover:bg-red-100 hover:text-red-500 dark:text-red-400 dark:hover:bg-red-500/20 dark:hover:text-red-300"
                        title="Hapus">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
                          viewBox="0 0 20 20"
                          fill="currentColor">
                          <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td
                  colspan="7"
                  class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                  Tidak ada produk ditemukan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if (isset($products) && $products->hasPages())
        <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-700">
          {{ $products->appends(request()->query())->links("vendor.pagination.tailwind") }}
        </div>
      @endif
    </div>
  </div>

  <script>
    function submitFilter() {
      document.getElementById('filterForm').submit()
    }
  </script>
@endsection
