<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'products_category'; // Pastikan nama tabel Bosh Ejet benar di sini
    protected $primaryKey = 'id_product_category'; // Pastikan primary key Bosh Ejet benar di sini
    public $timestamps = false; // Jika tabel ini tidak memiliki created_at/updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        // 'slug', // Jika sebelumnya ada slug dan sekarang dihapus, pastikan ini tidak ada
    ];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        // Parameter kedua adalah foreign key di tabel products
        // Parameter ketiga adalah local key (primary key) di tabel products_category
        return $this->hasMany(Product::class, 'id_product_category', 'id_product_category');
    }
}