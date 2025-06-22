<?php

namespace App\Http\Controllers\Sales; // Pastikan namespace sudah benar

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\VisitSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitScheduleController extends Controller
{
    public function index()
    {
        $schedules = VisitSchedule::with('customer')
            ->where('id_sales', Auth::guard('sales')->id())
            ->orderBy('start_time', 'asc')
            ->get();

        $customers = Customer::where('status', 'ACTIVE')->get(['id_customer', 'name_store']);

        return view('sales.visit-schedule', compact('schedules', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ]);

        VisitSchedule::create(array_merge($request->all(), [
            'id_sales' => Auth::guard('sales')->id(),
            'status' => 'Pending',
        ]));

        return redirect()->route('sales.visit_schedule.index')->with('success', 'Jadwal kunjungan berhasil ditambahkan.');
    }

    // Perhatikan nama variabel $visitSchedule, ini PENTING untuk Route Model Binding
    public function update(Request $request, VisitSchedule $visitSchedule)
    {
        if ((int)$visitSchedule->id_sales !== (int)Auth::guard('sales')->id()) {
            abort(403);
        }

        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:Pending,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        $visitSchedule->update($request->all());

        return redirect()->route('sales.visit_schedule.index')->with('success', 'Jadwal kunjungan berhasil diperbarui.');
    }

    // Perhatikan nama variabel $visitSchedule
    public function destroy(VisitSchedule $visitSchedule)
    {
        if ((int)$visitSchedule->id_sales !== (int)Auth::guard('sales')->id()) {
            abort(403);
        }

        $visitSchedule->delete();

        return redirect()->route('sales.visit_schedule.index')->with('success', 'Jadwal kunjungan berhasil dibatalkan.');
    }
}
