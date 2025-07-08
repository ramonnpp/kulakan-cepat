<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PerformanceReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $salesId;
    protected $startDate;
    protected $endDate;

    public function __construct(int $salesId, Carbon $startDate, Carbon $endDate)
    {
        $this->salesId = $salesId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data transaksi berdasarkan sales dan rentang tanggal
        return Transaction::with('customer')
            ->whereHas('customer', function ($query) {
                $query->where('id_sales', $this->salesId);
            })
            ->where('status', 'FINISH')
            ->whereBetween('date_transaction', [$this->startDate, $this->endDate])
            ->orderBy('date_transaction', 'desc')
            ->get();
    }

    /**
     * Menentukan header untuk kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal Transaksi',
            'Nama Pelanggan',
            'Total Harga (Rp)',
            'Status',
        ];
    }

    /**
     * Memetakan data dari collection ke baris di file Excel.
     */
    public function map($transaction): array
    {
        return [
            $transaction->id,
            Carbon::parse($transaction->date_transaction)->isoFormat('D MMMM YYYY, HH:mm'),
            $transaction->customer->name_store ?? 'Pelanggan Dihapus',
            $transaction->total_price,
            $transaction->status,
        ];
    }
}
