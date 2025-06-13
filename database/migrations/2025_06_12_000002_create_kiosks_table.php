<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kiosks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->constrained()->cascadeOnDelete();
            $table->string('kiosk_no');
            $table->string('category');
            $table->decimal('area_m2', 8, 2)->default(0);
            $table->enum('status', ['available', 'occupied', 'inactive'])->default('available');
            $table->timestamps();

            $table->unique(['market_id', 'kiosk_no']); // one number per market
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kiosks');
    }
};
