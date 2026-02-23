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
        Schema::connection('unitus_central_db')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('fullname')->nullable();
            $table->string('password'); 
            $table->enum('role', ['admin', 'employee'])->default('employee'); 
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('unitus_central_db')->dropIfExists('users');    

    }
};
