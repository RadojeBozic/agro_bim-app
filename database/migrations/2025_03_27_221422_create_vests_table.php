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
        Schema::create('vests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autor_id')->constrained('users')->onDelete('cascade');
            $table->string('naslov');
            $table->text('sadrzaj');
            $table->string('kategorija')->default('agrar');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vests');
    }
};
