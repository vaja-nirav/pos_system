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
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $blueprint) {
                $blueprint->id();
                $blueprint->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $blueprint->string('action');
                $blueprint->string('module');
                $blueprint->text('description')->nullable();
                $blueprint->ipAddress('ip_address')->nullable();
                $blueprint->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
