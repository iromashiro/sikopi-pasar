<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('levy_id')->constrained()->cascadeOnDelete();
            $table->date('paid_at');
            $table->unsignedBigInteger('amount');
            $table->string('method', 30)->default('cash');
            $table->string('receipt_no')->unique();
            $table->string('collector_name')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
