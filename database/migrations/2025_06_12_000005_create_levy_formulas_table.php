<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('levy_formulas', function (Blueprint $table) {
            $table->id();

            // Base rate for levy calculation (max: 9999999999.99)
            $table->decimal('base_rate', 12, 2)->unsigned();

            // Category multiplier (max: 999.999)
            $table->decimal('category_mult', 6, 3)->unsigned()->default(1.000);

            // Area multiplier (max: 999.999)
            $table->decimal('area_mult', 6, 3)->unsigned()->default(1.000);

            // JSON overrides for specific kiosk categories
            // Format: {"category_name": rate_value}
            $table->json('overrides')->nullable();

            // Formula version number
            $table->unsignedSmallInteger('version')->default(1);

            // When this formula becomes effective
            $table->date('effective_date')->useCurrent();

            // Standard timestamps
            $table->timestamps();

            // Add indexes for better performance
            $table->index('effective_date');
            $table->index(['version', 'effective_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levy_formulas');
    }
};
