<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggans');
            $table->date('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
