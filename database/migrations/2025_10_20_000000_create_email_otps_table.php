<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code_hash');
            $table->unsignedSmallInteger('attempts')->default(0);
            $table->unsignedSmallInteger('sent_count')->default(0);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('consumed_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_otps');
    }
};
