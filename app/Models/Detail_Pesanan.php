<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_pesanan')->nullable()->constrained('pesanans');
            $table->foreignId('id_produk')->nullable()->constrained('produks');
            $table->integer('jumlah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
