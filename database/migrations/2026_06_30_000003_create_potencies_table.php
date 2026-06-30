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
        Schema::create('potencies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // e.g., 'UMKM', 'Wisata', 'Komoditas'
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('contact_person')->nullable(); // owner's WhatsApp number
            $table->string('price_range')->nullable(); // price range for products/tourism ticket
            $table->text('location')->nullable(); // location description or map link
            $table->timestamps();

            // Indexes for fast querying as per PRD
            $table->index('title');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potencies');
    }
};
