<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trader_kiosk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trader_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kiosk_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // null => active
            $table->timestamps();

            $table->unique(['kiosk_id', 'end_date']); // prevent >1 active assignment
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('trader_kiosk');
    }
};
