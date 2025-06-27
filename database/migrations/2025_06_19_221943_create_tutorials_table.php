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
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap tutorial
            $table->string('title'); // Judul tutorial
            $table->string('course_code'); // Kode mata kuliah
            $table->string('course_name')->nullable();
            $table->string('presentation_url')->unique(); // URL presentasi, harus unik
            $table->string('finished_url')->unique(); // URL PDF, harus unik
            $table->string('creator_email'); // Email pembuat
            $table->timestamps(); // Otomatis membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorials');
    }
};
