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
    Schema::create('dokuments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('gazdinstvo_id')->constrained()->onDelete('cascade');
        $table->string('naziv');
        $table->string('putanja'); // putanja do fajla
        $table->string('tip')->nullable(); // PDF, JPG, DOC...
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokuments');
    }
};
