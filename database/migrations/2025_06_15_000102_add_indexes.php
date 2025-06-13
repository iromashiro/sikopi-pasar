<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $t) {
            $t->index(['entity', 'entity_id']);
            $t->index(['user_id', 'created_at']);
            $t->index('created_at');
        });
        Schema::table('trader_kiosk', function (Blueprint $t) {
            $t->index(['trader_id', 'end_date']);
            $t->index('start_date');
        });
    }
    public function down(): void
    { /* drop indexes */
    }
};
