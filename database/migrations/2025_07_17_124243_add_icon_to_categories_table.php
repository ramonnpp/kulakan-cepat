<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PERBAIKAN: Menggunakan nama tabel 'products_category' yang benar
        Schema::table('products_category', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Menggunakan nama tabel 'products_category' yang benar
        Schema::table('products_category', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};