<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('action');          // created / updated / deleted / login / etc
            $table->string('entity');          // Model class
            $table->unsignedBigInteger('entity_id');
            $table->jsonb('before')->nullable();
            $table->jsonb('after')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('ua', 512)->nullable();
            $table->timestamp('created_at')->useCurrent();
            // NO updated_at ⇒ append-only
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
