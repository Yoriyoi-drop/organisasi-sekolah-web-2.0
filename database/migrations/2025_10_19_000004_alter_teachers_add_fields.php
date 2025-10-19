<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'email')) {
                $table->string('email')->unique()->nullable();
            }
            if (!Schema::hasColumn('teachers', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'subject')) {
                $table->string('subject')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'qualification')) {
                $table->string('qualification')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'qualification')) {
                $table->dropColumn('qualification');
            }
            if (Schema::hasColumn('teachers', 'subject')) {
                $table->dropColumn('subject');
            }
            if (Schema::hasColumn('teachers', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('teachers', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
