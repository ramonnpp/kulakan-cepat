<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'transaction';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_transaction';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id_customer',
        'invoice_number',
        'date_transaction',
        'total_price',
        'method_payment',
        'status',
        'payment_due_date',
        'paid_at',
        'shipping_address',
        'shipping_cost',
    ];

    /**
     * Casting tipe data untuk atribut.
     *
     * @var array
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'date_transaction' => 'datetime',
        'payment_due_date' => 'datetime',
        'paid_at' => 'datetime',
        'shipping_address' => 'array', // **PERBAIKAN UTAMA DI SINI**
    ];

    /**
     * Relasi ke model Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    /**
     * Relasi ke model TransactionDetail.
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction', 'id_transaction');
    }
}
