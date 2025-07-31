<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\CustomerVisitNote;
use App\Models\Product; // <--- PERBAIKAN: Tambahkan baris ini

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $salesId = Auth::guard('sales')->id();
        $query = Customer::where('id_sales', $salesId);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_store', 'like', "%{$searchTerm}%")
                    ->orWhere('name_owner', 'like', "%{$searchTerm}%")
                    ->orWhere('no_phone', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(10)->appends($request->query());

        return view('sales.customers', compact('customers'));
    }

    public function show(Customer $customer)
    {
        if ($customer->id_sales != Auth::guard('sales')->id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $transactions = Transaction::where('id_customer', $customer->id_customer)->orderBy('date_transaction', 'desc')->get();
        $visitNotes = CustomerVisitNote::where('id_customer', $customer->id_customer)->orderBy('created_at', 'desc')->get();

        $mostBoughtProducts = $customer->load('transactions.details.product')
            ->transactions
            ->flatMap(fn($t) => $t->details)
            ->groupBy('id_product')
            ->map(function ($details) {
                if ($details->first()->product) {
                    return (object) [
                        'name_product' => $details->first()->product->name_product,
                        'total_quantity' => $details->sum('quantity'),
                    ];
                }
                return null;
            })
            ->filter()
            ->sortByDesc('total_quantity')
            ->take(5);

        return view('sales.customer-detail', compact('customer', 'transactions', 'visitNotes', 'mostBoughtProducts'));
    }

    public function storeVisitNote(Request $request, $customerId)
    {
        $request->validate(['note_text' => 'required|string']);

        CustomerVisitNote::create([
            'id_customer' => $customerId,
            'id_sales' => Auth::guard('sales')->id(),
            'note_text' => $request->note_text,
        ]);

        return back()->with('success', 'Catatan kunjungan berhasil ditambahkan.');
    }

    public function showOrder(Transaction $transaction)
    {
        if ($transaction->customer->id_sales !== Auth::guard('sales')->id()) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $transaction->load('details.product');
        return response()->json($transaction);
    }

    public function profile()
    {
        $sales = Auth::guard('sales')->user();
        return view('sales.profile', compact('sales'));
    }

    public function updateProfile(Request $request)
    {
        $sales = Auth::guard('sales')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:sales,email,' . $sales->id_sales . ',id_sales',
            'no_phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $sales->name = $request->name;
        $sales->email = $request->email;
        $sales->no_phone = $request->no_phone;

        if ($request->filled('password')) {
            $sales->password = $request->password;
        }

        $sales->save();

        return redirect()->route('sales.profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $sales = Auth::guard('sales')->user();

        if ($sales->foto_profil) {
            Storage::disk('public')->delete($sales->foto_profil);
        }

        $path = $request->file('foto_profil')->store('sales_profiles', 'public');
        $sales->foto_profil = $path;
        $sales->save();

        return redirect()->route('sales.profile.show')->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updateOrderStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::in(['WAITING_CONFIRMATION', 'PROCESS', 'SEND', 'FINISH', 'CANCEL'])],
        ]);

        if ($transaction->customer->id_sales !== Auth::guard('sales')->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah status pesanan ini.');
        }

        $transaction->status = $request->status;
        $transaction->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // --- FUNGSI BARU UNTUK SCANNER ---

    public function qrCodes()
    {
        // PERBAIKAN: Menghapus ->where('status', 'ACTIVE') karena kolom status tidak ada
        $products = Product::all();
        return view('sales.qr_codes', compact('products'));
    }

    public function scanner()
    {
        $salesId = Auth::guard('sales')->id();
        $customers = Customer::where('id_sales', $salesId)->where('status', 'ACTIVE')->get();
        return view('sales.scanner', compact('customers'));
    }

    public function getProductBySku($sku)
    {
        $product = Product::where('SKU', $sku)->first();

        if ($product) {
            return response()->json($product);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer,id_customer',
            'cart' => 'required|json'
        ]);

        $cartItems = json_decode($request->cart, true);
        $customerId = $request->customer_id;

        if (empty($cartItems)) {
            return redirect()->route('sales.scanner')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            $totalPrice = array_reduce($cartItems, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            $transaction = Transaction::create([
                'id_customer'      => $customerId,
                'date_transaction' => now(),
                'total_price'      => $totalPrice,
                'status'           => 'FINISH',
                'method_payment'   => 'CASH',
            ]);

            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_product'     => $item['id_product'],
                    'quantity'       => $item['quantity'],
                    'unit_price'     => $item['price'],
                ]);

                $product = Product::find($item['id_product']);
                if ($product) {
                    $product->total_stock -= $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            return redirect()->route('sales.customers.show', $customerId)->with('success', 'Transaksi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->route('sales.scanner')->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }
}
