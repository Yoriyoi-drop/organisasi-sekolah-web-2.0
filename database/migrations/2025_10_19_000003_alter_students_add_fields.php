<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'email')) {
                $table->string('email')->unique()->nullable();
            }
            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('students', 'class')) {
                $table->string('class')->nullable();
            }
            if (!Schema::hasColumn('students', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('students', 'class')) {
                $table->dropColumn('class');
            }
            if (Schema::hasColumn('students', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('students', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
