<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            // Tambahkan baris ini
            $table->string('avatar')->nullable()->after('name_store'); // Simpan path gambar, boleh kosong
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            // Kode untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('avatar');
        });
    }
};
