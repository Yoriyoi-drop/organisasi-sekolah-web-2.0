<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('activities', 'date')) {
                $table->date('date')->nullable();
            }
            if (!Schema::hasColumn('activities', 'location')) {
                $table->string('location')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('activities', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('activities', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
