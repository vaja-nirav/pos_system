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
        Schema::create('settings', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $blueprint->string('key')->unique(); // If we want global unique keys, or we can make it unique per store
            $blueprint->text('value')->nullable();
            $blueprint->timestamps();
            
            // If settings are per store, we might want a unique constraint on (store_id, key)
            // But let's check if the user wants global or per store.
            // "Multi Store Ready Structure" suggests per store.
            $blueprint->dropUnique(['key']);
            $blueprint->unique(['store_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
