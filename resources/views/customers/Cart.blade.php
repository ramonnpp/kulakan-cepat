@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
  <main class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">Keranjang Belanja</h1>
        <a
          href="{{ route('catalog.index') }}"
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50">
          <i class="fas fa-arrow-left text-xs"></i>
          Lanjut Belanja
        </a>
      </div>

      @if (session('success'))
        <div
          class="mb-4 rounded-lg border border-green-400 bg-green-100 px-4 py-3 text-green-700"
          role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      @if (session('error'))
        <div
          class="mb-4 rounded-lg border border-red-400 bg-red-100 px-4 py-3 text-red-700"
          role="alert">
          <span class="block sm:inline">{{ session('error') }}</span>
        </div>
      @endif

      <div class="flex flex-col gap-8 lg:flex-row">
        {{-- Kolom Produk --}}
        <div class="w-full lg:w-2/3">
          @if (count($cartItems) > 0)
            <div
              class="mb-4 flex items-center justify-between rounded-xl border bg-white p-4 shadow-sm">
              <label class="flex items-center gap-3">
                <input
                  type="checkbox"
                  class="h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-red-500"
                  id="check-all" />
                <span class="text-sm font-medium text-gray-800">
                  Pilih Semua ({{ count($cartItems) }})
                </span>
              </label>
            </div>

            {{-- Loop Item Keranjang --}}
            <div class="space-y-4">
              @foreach ($cartItems as $id => $item)
                <div
                  class="cart-item-card mb-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md">
                  <div class="flex items-start gap-4">
                    <input
                      type="checkbox"
                      class="check-item mt-8 h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-red-500"
                      name="selected_items[]"
                      value="{{ $id }}" />
                    <div
                      class="cart-item flex flex-1 items-start gap-4"
                      data-price="{{ $item['price'] }}"
                      data-id="{{ $id }}">
                      <img
                        src="{{ $item['image'] ? Storage::url($item['image']) : 'https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar' }}"
                        class="h-24 w-24 rounded-lg border object-cover"
                        alt="{{ $item['name'] }}" />
                      <div class="flex-grow">
                        <h4 class="font-semibold text-gray-900">{{ $item['name'] }}</h4>
                        <p class="text-sm text-gray-500">
                          {{ \Illuminate\Support\Str::limit($item['description'] ?? 'Tidak ada deskripsi', 50) }}
                        </p>
                        <div class="mt-2 text-lg font-bold text-red-700">
                          Rp{{ number_format($item['price'], 0, ',', '.') }}
                        </div>
                      </div>
                      <div class="flex flex-col items-end justify-between self-stretch">
                        <div class="flex items-center gap-2">
                          <button
                            type="button"
                            class="quantity-btn flex h-8 w-8 items-center justify-center rounded-md bg-gray-200 transition hover:bg-gray-300"
                            data-action="decrease"
                            data-id="{{ $id }}">
                            <i class="fas fa-minus text-xs"></i>
                          </button>
                          {{-- Input field is replaced by a span --}}
                          <span
                            class="quantity-display flex h-8 w-12 items-center justify-center text-center font-medium">
                            {{ $item['quantity'] }}
                          </span>
                          <button
                            type="button"
                            class="quantity-btn flex h-8 w-8 items-center justify-center rounded-md bg-gray-200 transition hover:bg-gray-300"
                            data-action="increase"
                            data-id="{{ $id }}">
                            <i class="fas fa-plus text-xs"></i>
                          </button>
                        </div>
                        <form
                          action="{{ route('cart.remove') }}"
                          method="POST"
                          class="delete-form">
                          @csrf
                          @method('DELETE')
                          <input type="hidden" name="id" value="{{ $id }}" />
                          <button
                            type="submit"
                            class="p-2 text-gray-400 transition hover:text-red-600">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="rounded-xl border bg-white p-10 text-center shadow-sm">
              <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
              <p class="mt-4 text-gray-700">Keranjang belanja Anda masih kosong.</p>
              <a
                href="{{ route('catalog.index') }}"
                class="mt-4 inline-block rounded-lg bg-red-700 px-6 py-2 font-bold text-white transition hover:bg-red-800">
                Mulai Belanja
              </a>
            </div>
          @endif
        </div>

        {{-- Ringkasan Belanja --}}
        @if (count($cartItems) > 0)
          <aside class="w-full lg:w-1/3">
            <div class="sticky top-24">
              <form id="checkout-form" action="{{ route('checkout.show') }}" method="GET">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-md">
                  <h5 class="mb-6 text-lg font-bold text-gray-800">Ringkasan Belanja</h5>
                  <div class="mb-4 flex justify-between text-gray-600">
                    <span>Total Harga</span>
                    <span id="total-price" class="text-xl font-bold text-red-700">Rp0</span>
                  </div>
                  <div id="hidden-items-container"></div>
                  <button
                    type="submit"
                    id="btn-checkout"
                    class="w-full rounded-lg bg-red-600 py-3 text-center font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    disabled>
                    Beli (0)
                  </button>
                </div>
              </form>

              {{-- Tombol Kosongkan Keranjang --}}
              <div class="mt-4">
                <form action="{{ route('cart.clear') }}" method="POST" class="clear-form">
                  @csrf
                  @method('DELETE')
                  <button
                    type="submit"
                    class="w-full rounded-lg border border-red-200 bg-red-50 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-100">
                    Kosongkan Keranjang
                  </button>
                </form>
              </div>
            </div>
          </aside>
        @endif
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      id="delete-modal"
      class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
      <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
        <div class="text-center">
          <i class="fas fa-exclamation-triangle text-4xl text-yellow-400"></i>
          <h3 id="modal-title" class="mt-4 text-lg font-bold text-gray-900">Konfirmasi</h3>
          <p id="modal-text" class="mt-2 text-sm text-gray-600">Anda yakin?</p>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-4">
          <button
            id="cancel-delete"
            type="button"
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Batal
          </button>
          <form id="confirm-delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" id="delete-item-id" />
            <button
              type="submit"
              class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
              Ya, Lanjutkan
            </button>
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Pastikan Anda memiliki meta tag ini di layout utama Anda: <meta name="csrf-token" content="{{ csrf_token() }}">
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const checkAll = document.getElementById('check-all')
      const checkItems = document.querySelectorAll('.check-item')
      if (checkItems.length === 0) return

      const totalPriceEl = document.getElementById('total-price')
      const btnCheckout = document.getElementById('btn-checkout')
      const hiddenItemsContainer = document.getElementById('hidden-items-container')
      let updateTimeout = null

      function updateCartSummary() {
        let total = 0
        let selectedCount = 0
        hiddenItemsContainer.innerHTML = ''

        checkItems.forEach((checkbox) => {
          const card = checkbox.closest('.cart-item-card')
          const itemData = card.querySelector('.cart-item')
          if (checkbox.checked) {
            const price = parseFloat(itemData.dataset.price)
            const quantity = parseInt(itemData.querySelector('.quantity-display').textContent)
            total += price * quantity
            selectedCount++

            const hiddenInput = document.createElement('input')
            hiddenInput.type = 'hidden'
            hiddenInput.name = 'items[]'
            hiddenInput.value = itemData.dataset.id
            hiddenItemsContainer.appendChild(hiddenInput)
          }
        })

        totalPriceEl.textContent = 'Rp' + total.toLocaleString('id-ID')
        btnCheckout.textContent = `Beli (${selectedCount})`

        if (selectedCount > 0) {
          btnCheckout.disabled = false
        } else {
          btnCheckout.disabled = true
        }
        checkAll.checked = checkItems.length > 0 && selectedCount === checkItems.length
      }

      // Function to update quantity using Fetch API (AJAX)
      async function submitQuantityUpdate(itemId, newQuantity) {
        if (!csrfToken) {
          console.error('CSRF token not found!')
          return
        }

        try {
          const response = await fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              Accept: 'application/json',
            },
            body: JSON.stringify({
              id: itemId,
              quantity: newQuantity,
            }),
          })

          if (!response.ok) {
            const errorData = await response.json()
            console.error('Gagal mengupdate keranjang:', errorData.message)
            // Di sini Anda bisa menambahkan logika untuk menampilkan pesan error ke user
          }
          // Tidak perlu melakukan apa-apa jika sukses, karena UI sudah diupdate
        } catch (error) {
          console.error('Terjadi kesalahan:', error)
        }
      }

      checkAll.addEventListener('change', function () {
        checkItems.forEach((checkbox) => {
          checkbox.checked = this.checked
        })
        updateCartSummary()
      })

      checkItems.forEach((checkbox) => {
        checkbox.addEventListener('change', updateCartSummary)
      })

      document.querySelectorAll('.quantity-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
          const action = this.dataset.action
          const itemId = this.dataset.id
          const itemCard = document.querySelector(`.cart-item[data-id="${itemId}"]`)
          const quantityDisplay = itemCard.querySelector('.quantity-display')

          let currentQuantity = parseInt(quantityDisplay.textContent)

          if (action === 'increase' && currentQuantity < 999) {
            currentQuantity++
          } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--
          }

          quantityDisplay.textContent = currentQuantity
          updateCartSummary()

          if (updateTimeout) clearTimeout(updateTimeout)
          updateTimeout = setTimeout(() => {
            submitQuantityUpdate(itemId, currentQuantity)
          }, 1000) // Kirim update setelah 1 detik tidak ada aktivitas
        })
      })

      // Modal Logic
      const deleteModal = document.getElementById('delete-modal')
      const modalTitle = document.getElementById('modal-title')
      const modalText = document.getElementById('modal-text')
      const cancelDeleteBtn = document.getElementById('cancel-delete')
      const confirmDeleteForm = document.getElementById('confirm-delete-form')
      const deleteItemIdInput = document.getElementById('delete-item-id')

      function showModal(config) {
        modalTitle.textContent = config.title
        modalText.textContent = config.text
        confirmDeleteForm.action = config.action
        if (config.itemId) {
          deleteItemIdInput.value = config.itemId
          deleteItemIdInput.disabled = false
        } else {
          deleteItemIdInput.disabled = true
        }
        deleteModal.classList.remove('hidden')
        deleteModal.classList.add('flex')
      }

      document.querySelectorAll('.delete-form').forEach((form) => {
        form.addEventListener('submit', function (e) {
          e.preventDefault()
          showModal({
            title: 'Hapus Item Ini?',
            text: 'Anda yakin ingin menghapus item ini dari keranjang?',
            action: this.action,
            itemId: this.querySelector('input[name="id"]').value,
          })
        })
      })

      document.querySelector('.clear-form')?.addEventListener('submit', function (e) {
        e.preventDefault()
        showModal({
          title: 'Kosongkan Keranjang?',
          text: 'Anda yakin ingin menghapus semua item dari keranjang belanja?',
          action: this.action,
          itemId: null,
        })
      })

      cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.add('hidden')
        deleteModal.classList.remove('flex')
      })

      updateCartSummary()
    })
  </script>
@endpush
