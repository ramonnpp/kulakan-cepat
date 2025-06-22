<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    use HasFactory;

    // Menentukan field mana saja yang boleh diisi secara massal
    protected $fillable = [
        'id_sales',
        'id_customer',
        'title',
        'notes',
        'start_time',
        'end_time',
        'status',
    ];

    // Mengubah tipe data kolom secara otomatis
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relasi ke model Sales: "Jadwal ini dimiliki oleh satu Sales"
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_sales', 'id_sales');
    }

    // Relasi ke model Customer: "Jadwal ini untuk satu Customer"
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
