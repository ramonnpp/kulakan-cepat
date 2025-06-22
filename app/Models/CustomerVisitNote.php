<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVisitNote extends Model
{
    use HasFactory;

    protected $table = 'customer_visit_notes';
    protected $primaryKey = 'id_note'; // Set primary key as id_note

    protected $fillable = [
        'id_customer',
        'note_text',
        'interaction_type',
        'id_sales',
    ];

    /**
     * Get the customer that owns the note.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    /**
     * Get the sales person who made the note.
     */
    public function salesPerson()
    {
        return $this->belongsTo(Sales::class, 'id_sales', 'id_sales');
    }
}
