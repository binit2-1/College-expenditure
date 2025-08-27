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
        Schema::table('expenditures', function (Blueprint $table) {
            // Update status to include more stages
            $table->dropColumn('status');
        });
        
        Schema::table('expenditures', function (Blueprint $table) {
            $table->enum('status', ['pending', 'hod_approved', 'hod_rejected', 'admin_approved', 'admin_rejected', 'final_approved'])->default('pending');
            
            // HoD approval fields
            $table->foreignId('hod_approved_by')->nullable()->constrained('users');
            $table->timestamp('hod_approved_at')->nullable();
            $table->text('hod_notes')->nullable();
            
            // Admin approval fields (rename existing)
            $table->renameColumn('approved_by', 'admin_approved_by');
            $table->renameColumn('approved_at', 'admin_approved_at');
            $table->renameColumn('approval_notes', 'admin_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropColumn(['hod_approved_by', 'hod_approved_at', 'hod_notes']);
            $table->renameColumn('admin_approved_by', 'approved_by');
            $table->renameColumn('admin_approved_at', 'approved_at'); 
            $table->renameColumn('admin_notes', 'approval_notes');
            $table->dropColumn('status');
        });
        
        Schema::table('expenditures', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }
};
