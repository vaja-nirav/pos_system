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
        Schema::create('warehouses', function (Blueprint $customer) {
            $customer->id();
            $customer->string('name');
            $customer->string('email')->nullable();
            $customer->string('phone_number')->nullable();
            $customer->string('country')->nullable();
            $customer->string('city')->nullable();
            $customer->string('zip_code')->nullable();
            $customer->boolean('status')->default(1);
            $customer->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
