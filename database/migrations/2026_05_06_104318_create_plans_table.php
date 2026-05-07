<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price_kobo')->default(0);
            $table->string('currency', 3)->default('NGN');
            $table->enum('billing_cycle', [
                'monthly',
                'yearly',
                'one_time'
            ])->default('monthly');
            $table->unsignedInteger('max_qr_codes')->nullable();
            $table->unsignedInteger('max_file_uploads')->nullable();
            $table->unsignedBigInteger('storage_limit_mb')->nullable();
            $table->unsignedInteger('max_scans_per_month')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};