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
        Schema::connection('unitus_central_db')->create ('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            
            // The slug must be unique and indexed for fast middleware lookups
            $table->string('slug')->unique()->index();
            $table->string('db_name')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('unitus_central_db')->dropIfExists('entreprises');    
    }
};
