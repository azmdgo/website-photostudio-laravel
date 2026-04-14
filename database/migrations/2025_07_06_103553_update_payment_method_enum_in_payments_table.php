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
        Schema::table('payments', function (Blueprint $table) {
            // Drop the existing enum column and recreate as nullable string
            $table->dropColumn('payment_method');
        });
        
        Schema::table('payments', function (Blueprint $table) {
            // Add new payment_method column as nullable string
            $table->string('payment_method')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer', 'ewallet'])->after('amount');
        });
    }
};
