<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement(
            'CREATE UNIQUE INDEX trader_kiosk_active_unique ON trader_kiosk (kiosk_id) WHERE end_date IS NULL'
        );
    }
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS trader_kiosk_active_unique');
    }
};
