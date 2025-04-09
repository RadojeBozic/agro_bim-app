<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gazdinstvos', function (Blueprint $table) {
            $table->id();

            // Veza sa korisnikom
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Podaci o gazdinstvu
            $table->string('naziv');
            $table->string('pib')->nullable(); // ako je registrovano
            $table->string('maticni_broj')->nullable();
            $table->string('adresa')->nullable();
            $table->enum('tip', ['porodično', 'komercijalno', 'mešovito'])->default('porodično');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gazdinstvos');
    }
};
