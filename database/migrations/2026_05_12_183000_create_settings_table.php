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
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $blueprint) {
                $blueprint->id();
                $blueprint->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
                $blueprint->string('key')->unique();
                $blueprint->text('value')->nullable();
                $blueprint->timestamps();
                $blueprint->dropUnique(['key']);
                $blueprint->unique(['store_id', 'key']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
