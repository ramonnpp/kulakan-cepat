<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        $addresses = $user->addresses()->latest()->get();
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang Anda kosong.');
        }

        // Pastikan item checkout ada di session
        session(['checkout_items' => $cartItems]);

        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));

        return view('customers.checkout', compact('addresses', 'cartItems', 'totalPrice'));
    }

    /**
     * Memproses pesanan dari halaman checkout.
     */
    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'address_id' => 'required|exists:addresses,id_address',
            'payment_method' => 'required|string|in:kredit_toko,transfer_bank',
        ]);

        /** @var \App\Models\Customer $user */
        $user = Auth::guard('customer')->user();
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item untuk di-checkout.');
        }

        $address = Address::find($validatedData['address_id']);
        if (!$address || $address->id_customer !== $user->id_customer) {
            return redirect()->back()->with('error', 'Alamat pengiriman tidak valid.');
        }

        DB::beginTransaction();

        try {
            $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $checkoutItems));

            // Membuat transaksi utama
            $transaction = Transaction::create([
                'id_customer' => $user->id_customer,
                'date_transaction' => now(),
                'total_price' => $totalPrice,
                'status' => ($validatedData['payment_method'] === 'kredit_toko') ? 'PROCESS' : 'WAITING_CONFIRMATION',
                'method_payment' => $validatedData['payment_method'],
                'shipping_address' => json_encode($address->toArray()), // Simpan alamat sebagai JSON
            ]);

            // Membuat detail transaksi untuk setiap produk
            foreach ($checkoutItems as $id => $item) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_product' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'], // **PERBAIKAN UTAMA DI SINI**
                ]);

                // Mengurangi stok produk
                Product::find($item['product_id'])->decrement('total_stock', $item['quantity']);

                // Hapus item dari keranjang utama di session
                session()->pull('cart.' . $id);
            }

            // Hapus item checkout dari session
            session()->forget('checkout_items');

            DB::commit();

            return redirect()->route('order.confirmation', $transaction)->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman konfirmasi pesanan.
     */
    public function confirmation(Transaction $transaction)
    {
        // Pastikan customer hanya bisa melihat transaksinya sendiri
        if ($transaction->id_customer !== Auth::guard('customer')->id()) {
            abort(403);
        }

        return view('customers.order-confirmation', compact('transaction'));
    }
}
