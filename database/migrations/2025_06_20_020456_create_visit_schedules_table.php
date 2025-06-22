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
        Schema::create('visit_schedules', function (Blueprint $table) {
            $table->id();
            // PERBAIKAN DI SINI
            $table->unsignedInteger('id_sales');
            $table->unsignedInteger('id_customer');
            // AKHIR PERBAIKAN

            $table->string('title');
            $table->text('notes')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending');
            $table->timestamps();

            // Kunci asing ke tabel sales dan customer
            // Pastikan nama tabel 'sales' dan 'customer' sudah benar
            // onDelete('cascade') artinya jika sales/customer dihapus, jadwalnya ikut terhapus
            $table->foreign('id_sales')->references('id_sales')->on('sales')->onDelete('cascade');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_schedules');
    }
};
