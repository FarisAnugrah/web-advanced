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
        Schema::create('tutorial_details', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel 'tutorials'
            // onDelete('cascade') berarti jika tutorial dihapus, semua detailnya juga terhapus.
            $table->foreignId('tutorial_id')->constrained()->onDelete('cascade');
            $table->enum('content_type', ['text', 'image', 'code', 'url']); // Tipe konten
            $table->text('content_text')->nullable(); // Untuk menyimpan teks, kode, atau url
            $table->string('content_image_path')->nullable(); // Path ke file gambar yang diupload
            $table->integer('sort_order'); // Urutan langkah
            $table->enum('status', ['show', 'hide'])->default('hide'); // Status tampil/sembunyi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_details');
    }
};
