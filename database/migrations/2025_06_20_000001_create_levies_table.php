<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('levies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_kiosk_id')->constrained('trader_kiosk')->cascadeOnDelete();
            $table->char('period_month', 6)->index();        // yyyymm
            $table->date('due_date');
            $table->unsignedBigInteger('amount');            // stored in rupiah
            $table->enum('status', ['pending', 'partial', 'paid', 'overdue'])
                ->default('pending')->index();
            $table->unsignedSmallInteger('formula_version');
            $table->timestamps();
            $table->unique(['trader_kiosk_id', 'period_month']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('levies');
    }
};
