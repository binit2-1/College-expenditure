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
        Schema::create('uc_expenditures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uc_id')->constrained('utilisation_certificates')->onDelete('cascade');
            $table->foreignId('expenditure_id')->constrained('expenditures')->onDelete('cascade');
            $table->unique(['uc_id', 'expenditure_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uc_expenditures');
    }
};
