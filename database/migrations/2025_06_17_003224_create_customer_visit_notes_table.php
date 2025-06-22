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
        Schema::create('customer_visit_notes', function (Blueprint $table) {
            $table->increments('id_note'); // Primary Key for the note
            $table->unsignedInteger('id_customer'); // Foreign key to customer table
            $table->text('note_text'); // The actual note content
            $table->string('interaction_type')->nullable(); // e.g., 'Telepon', 'Kunjungan Langsung', 'Email'
            $table->unsignedInteger('id_sales')->nullable(); // Optional: Who made the note
            $table->timestamps(); // Adds created_at and updated_at columns

            $table->foreign('id_customer')
                ->references('id_customer')
                ->on('customer')
                ->onDelete('cascade'); // If customer is deleted, their notes are also deleted

            $table->foreign('id_sales')
                ->references('id_sales')
                ->on('sales')
                ->onDelete('set null'); // If sales is deleted, their id on notes becomes null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_visit_notes');
    }
};
