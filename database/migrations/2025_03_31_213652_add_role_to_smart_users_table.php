<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
    public function up()
    {
        Schema::table('smart_users', function (Blueprint $table) {
            $table->string('role')->default('kupac'); // ili 'admin'
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smart_users', function (Blueprint $table) {
            //
        });
    }
};
