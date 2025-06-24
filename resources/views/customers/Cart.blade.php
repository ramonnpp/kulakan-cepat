@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
  <main class="container mx-auto my-6 px-4">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-xl font-bold text-gray-800">Keranjang Belanja Anda</h3>
      <a href="{{ route('catalog.index') }}" class="text-sm text-red-600 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>
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

    <div class="flex flex-col gap-6 lg:flex-row">
      {{-- Kolom Produk --}}
      <div class="w-full lg:w-2/3">
        @if (count($cartItems) > 0)
          <div
            class="mb-4 flex items-center justify-between rounded-xl border bg-white p-4 shadow-sm">
            <label class="flex items-center gap-3">
              <input type="checkbox" class="h-5 w-5 accent-red-600" id="check-all" />
              <span class="text-sm font-medium text-gray-800">
                Pilih Semua ({{ count($cartItems) }})
              </span>
            </label>
          </div>

          {{-- Loop Item Keranjang --}}
          @foreach ($cartItems as $id => $item)
            <div
              class="cart-item-card mb-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md">
              <div
                class="cart-item flex items-start gap-4"
                data-price="{{ $item['price'] }}"
                data-id="{{ $id }}">
                <input
                  type="checkbox"
                  class="check-item mt-8 h-5 w-5 accent-red-600"
                  name="selected_items[]"
                  value="{{ $id }}" />
                <img
                  src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar' }}"
                  class="h-24 w-24 rounded-lg border object-cover"
                  alt="{{ $item['name'] }}" />
                <div class="flex-grow">
                  <h4 class="font-semibold text-gray-900">{{ $item['name'] }}</h4>
                  <p class="text-sm text-gray-500">
                    {{ \Illuminate\Support\Str::limit($item['description'] ?? 'Tidak ada deskripsi', 50) }}
                  </p>
                  <div class="mt-2 font-bold text-red-700">
                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                  </div>

                  <div class="mt-3 flex items-center justify-between">
                    {{-- Update Kuantitas --}}
                    <div class="flex items-center gap-2">
                      <button
                        type="button"
                        class="quantity-btn flex h-8 w-8 items-center justify-center rounded-md bg-gray-200 transition hover:bg-gray-300"
                        data-action="decrease"
                        data-id="{{ $id }}">
                        <i class="fas fa-minus text-xs"></i>
                      </button>
                      <input
                        type="number"
                        class="quantity-input h-8 w-16 rounded-md border text-center"
                        value="{{ $item['quantity'] }}"
                        min="1"
                        max="999"
                        data-id="{{ $id }}" />
                      <button
                        type="button"
                        class="quantity-btn flex h-8 w-8 items-center justify-center rounded-md bg-gray-200 transition hover:bg-gray-300"
                        data-action="increase"
                        data-id="{{ $id }}">
                        <i class="fas fa-plus text-xs"></i>
                      </button>
                    </div>

                    {{-- Hapus Produk --}}
                    <form action="{{ route('cart.remove') }}" method="POST" class="delete-form">
                      @csrf
                      @method('DELETE')
                      <input type="hidden" name="id" value="{{ $id }}" />
                      <button
                        type="submit"
                        class="p-2 text-gray-400 transition hover:text-red-600"
                        onclick="return confirm('Anda yakin ingin menghapus item ini?')">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            

            {{-- Form tersembunyi untuk update quantity --}}
            <form
              action="{{ route('cart.update') }}"
              method="POST"
              class="update-form hidden"
              data-id="{{ $id }}">
              @csrf
              @method('PATCH')
              <input type="hidden" name="id" value="{{ $id }}" />
              <input
                type="hidden"
                name="quantity"
                class="hidden-quantity"
                value="{{ $item['quantity'] }}" />
            </form>
          @endforeach
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
          <form id="checkout-form" action="{{ route('checkout.show') }}" method="GET">
            <div class="sticky top-24 rounded-xl border border-gray-200 bg-white p-6 shadow-md">
              <h5 class="mb-6 text-lg font-bold text-gray-800">Ringkasan Belanja</h5>
              <div class="mb-4 flex justify-between text-gray-600">
                <span>Total Harga</span>
                <span id="total-price" class="text-xl font-bold text-red-700">Rp0</span>
              </div>
              <button
                type="submit"
                id="btn-checkout"
                class="pointer-events-none block w-full rounded-lg bg-red-600 py-3 text-center font-semibold text-white opacity-50 transition hover:bg-red-700">
                Beli (0)
              </button>
            </div>
          </form>

          {{-- Tombol Kosongkan Keranjang --}}
  <div class="mt-4">
            {{-- Hapus atribut onsubmit dari form ini --}}
            <form action="{{ route('cart.clear') }}" method="POST" id="clear-cart-form">
              @csrf
              @method('DELETE')
              <button
                type="button" {{-- UBAH INI KE type="button" --}}
                class="w-full text-sm text-red-600 underline hover:text-red-800"
                @click="window.confirmModal({
                    formId: 'clear-cart-form',
                    actionText: 'Anda yakin ingin mengosongkan seluruh keranjang?',
                    confirmCallback: () => {
                        document.getElementById('clear-cart-form').submit();
                    }
                })">
                Kosongkan Keranjang
              </button>
            </form>
          </div>
        </aside>
      @endif
    </div>
  </main>

  {{-- MODAL KONFIRMASI (Dengan ikon yang diubah) --}}
  <div x-data="{ show: false, formId: null, actionText: '', confirmCallback: null }"
      x-show="show"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      class="fixed inset-0 z-[9999] overflow-y-auto"
      aria-labelledby="modal-title" role="dialog" aria-modal="true"
      style="display: none;" {{-- Hidden by default, Alpine.js will manage this --}}>

      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
              <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                  <div>
                      {{-- ICON BARU: question-circle dari Font Awesome --}}
                      <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                          <i class="fas fa-question-circle text-3xl text-blue-600"></i> {{-- Menggunakan Font Awesome --}}
                      </div>
                      <div class="mt-3 text-center sm:mt-5">
                          <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title" x-text="actionText"></h3>
                          <div class="mt-2">
                              <p class="text-sm text-gray-500">
                                  Tindakan ini tidak dapat dibatalkan.
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                      <button type="button"
                          @click="if (confirmCallback) { confirmCallback(); }; show = false;"
                          class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 sm:col-start-2">
                          Ya, Lanjutkan!
                      </button>
                      <button type="button"
                          @click="show = false"
                          class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">
                          Batal
                      </button>
                  </div>
              </div>
          </div>
      </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const checkAll = document.getElementById('check-all')
      const checkItems = document.querySelectorAll('.check-item')
      const totalPriceEl = document.getElementById('total-price')
      const btnCheckout = document.getElementById('btn-checkout')
      const checkoutForm = document.getElementById('checkout-form')
      const quantityInputs = document.querySelectorAll('.quantity-input')
      const quantityBtns = document.querySelectorAll('.quantity-btn')

      // Jika tidak ada item di keranjang, keluar dari fungsi
      if (checkItems.length === 0) return

      // Variabel untuk menampung timeout update
      let updateTimeout = null

      // Fungsi untuk memperbarui ringkasan keranjang
      function updateCartSummary() {
        let totalPrice = 0
        let selectedItemCount = 0

        // Hapus input lama untuk mencegah duplikasi
        checkoutForm.querySelectorAll('input[name="items[]"]').forEach((input) => input.remove())

        checkItems.forEach((itemCheckbox) => {
          const cartItem = itemCheckbox.closest('.cart-item')
          const quantityInput = cartItem.querySelector('.quantity-input')

          if (itemCheckbox.checked && quantityInput) {
            const price = parseFloat(cartItem.dataset.price)
            const quantity = parseInt(quantityInput.value)
            const itemId = cartItem.dataset.id

            totalPrice += price * quantity
            selectedItemCount++

            // Tambahkan input tersembunyi untuk item yang dipilih
            const hiddenInput = document.createElement('input')
            hiddenInput.type = 'hidden'
            hiddenInput.name = 'items[]'
            hiddenInput.value = itemId
            checkoutForm.appendChild(hiddenInput)
          }
        })

        // Update tampilan total harga dan tombol checkout
        totalPriceEl.textContent = 'Rp' + totalPrice.toLocaleString('id-ID')
        btnCheckout.textContent = `Beli (${selectedItemCount})`

        // Enable/disable tombol checkout
        if (selectedItemCount === 0) {
          btnCheckout.classList.add('opacity-50', 'pointer-events-none')
        } else {
          btnCheckout.classList.remove('opacity-50', 'pointer-events-none')
        }
      }

      // Fungsi Kosongkan Keranjang
      window.confirmModal = (options) => {
        let modal = document.querySelector('[x-data*="confirmCallback"]')._x_dataStack[0];
        // Pastikan modal ditemukan sebelum mencoba mengakses propertinya
        if (modal) {
            modal.formId = options.formId || null;
            modal.actionText = options.actionText || 'Anda yakin?';
            modal.confirmCallback = options.confirmCallback || null;
            modal.show = true;
        } else {
            console.error('Confirm modal element not found for Alpine.js data binding.');
            // Fallback ke confirm() bawaan jika modal tidak ditemukan (opsional)
            if (options.confirmCallback && confirm(options.actionText + '\n' + 'Tindakan ini tidak dapat dibatalkan.')) {
                options.confirmCallback();
            }
        }
    }

      // Fungsi untuk submit update quantity
      function submitQuantityUpdate(itemId, newQuantity) {
        const updateForm = document.querySelector(`.update-form[data-id="${itemId}"]`)
        if (!updateForm) {
          console.error('Update form not found for item:', itemId)
          return
        }

        const hiddenQuantity = updateForm.querySelector('.hidden-quantity')
        if (hiddenQuantity) {
          hiddenQuantity.value = newQuantity
          updateForm.submit()
        }
      }

      // Event listener untuk checkbox "Pilih Semua"
      if (checkAll) {
        checkAll.addEventListener('change', function () {
          checkItems.forEach((cb) => (cb.checked = this.checked))
          updateCartSummary()
        })
      }

      // Event listener untuk setiap checkbox item
      checkItems.forEach((itemCheckbox) => {
        itemCheckbox.addEventListener('change', () => {
          // Cek apakah semua item dipilih
          let allChecked = true
          checkItems.forEach((cb) => {
            if (!cb.checked) allChecked = false
          })
          if (checkAll) checkAll.checked = allChecked
          updateCartSummary()
        })
      })

      // Event listener untuk tombol quantity (+ dan -)
      quantityBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
          const action = this.dataset.action
          const itemId = this.dataset.id
          const quantityInput = document.querySelector(`.quantity-input[data-id="${itemId}"]`)

          if (!quantityInput) {
            console.error('Quantity input not found for item:', itemId)
            return
          }

          let currentQuantity = parseInt(quantityInput.value) || 1

          if (action === 'increase') {
            if (currentQuantity < 999) {
              currentQuantity++
            }
          } else if (action === 'decrease') {
            if (currentQuantity > 1) {
              currentQuantity--
            }
          }

          // Update nilai input
          quantityInput.value = currentQuantity

          // Update ringkasan keranjang langsung
          updateCartSummary()

          // Clear timeout sebelumnya dan set yang baru
          if (updateTimeout) {
            clearTimeout(updateTimeout)
          }

          updateTimeout = setTimeout(() => {
            submitQuantityUpdate(itemId, currentQuantity)
          }, 1500) // Delay 1.5 detik
        })
      })

      // Event listener untuk input quantity manual
      quantityInputs.forEach((input) => {
        input.addEventListener('change', function () {
          const itemId = this.dataset.id
          let newQuantity = parseInt(this.value) || 1

          // Validasi nilai
          if (newQuantity < 1) {
            newQuantity = 1
            this.value = 1
          } else if (newQuantity > 999) {
            newQuantity = 999
            this.value = 999
          }

          updateCartSummary()

          // Clear timeout sebelumnya dan set yang baru
          if (updateTimeout) {
            clearTimeout(updateTimeout)
          }

          updateTimeout = setTimeout(() => {
            submitQuantityUpdate(itemId, newQuantity)
          }, 1500)
        })

        // Prevent submit saat user masih mengetik
        input.addEventListener('keydown', function (e) {
          if (e.key === 'Enter') {
            e.preventDefault()
            this.blur() // Trigger change event
          }
        })
      })

      // Inisialisasi ringkasan keranjang saat halaman dimuat
      updateCartSummary()

      // Debug info
      console.log('Cart items found:', checkItems.length)
      console.log('Quantity inputs found:', quantityInputs.length)
      console.log('Quantity buttons found:', quantityBtns.length)
    })
  </script>
@endpush
