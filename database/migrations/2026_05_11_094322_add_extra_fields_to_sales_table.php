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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('payment_type')->default('Cash')->after('payment_status');
            $table->decimal('shipping', 12, 2)->default(0)->after('tax');
            $table->decimal('tax_percent', 5, 2)->default(0)->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'shipping', 'tax_percent']);
        });
    }
};
