<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\CustomerVisitNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class SalesController extends Controller
{
    /**
     * Menampilkan daftar pelanggan dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        $salesId = Auth::guard('sales')->id();
        $query = Customer::where('id_sales', $salesId);

        // Menerapkan filter pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_store', 'like', "%{$searchTerm}%")
                    ->orWhere('owner', 'like', "%{$searchTerm}%")
                    ->orWhere('no_phone', 'like', "%{$searchTerm}%");
            });
        }

        // Menerapkan filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(10)->appends($request->query());

        return view('sales.customers', compact('customers'));
    }

    /**
     * Menampilkan detail satu pelanggan.
     */
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

    /**
     * Menyimpan catatan kunjungan baru.
     */
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

    /**
     * Menampilkan detail pesanan untuk modal.
     */
    public function showOrder(Transaction $transaction)
    {
        if ($transaction->customer->id_sales !== Auth::guard('sales')->id()) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $transaction->load('details.product');
        return response()->json($transaction);
    }

    /**
     * Menampilkan halaman profil sales.
     */
    public function profile()
    {
        $sales = Auth::guard('sales')->user();
        return view('sales.profile', compact('sales'));
    }

    /**
     * Memperbarui data profil sales.
     */
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

        // --- PERBAIKAN UTAMA DI SINI ---
        if ($request->filled('password')) {
            // JANGAN gunakan bcrypt() di sini.
            // Biarkan Model Mutator yang mengenkripsi secara otomatis.
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

        /** @var \App\Models\Sales $sales */
        $sales = Auth::guard('sales')->user();

        // Hapus foto lama jika ada
        if ($sales->foto_profil) {
            Storage::disk('public')->delete($sales->foto_profil);
        }

        // Simpan foto baru dan update path di database
        $path = $request->file('foto_profil')->store('sales_profiles', 'public');
        $sales->foto_profil = $path;
        $sales->save();

        return redirect()->route('sales.profile.show')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
