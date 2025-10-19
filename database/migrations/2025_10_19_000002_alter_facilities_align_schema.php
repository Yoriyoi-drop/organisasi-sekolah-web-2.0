<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            if (Schema::hasColumn('facilities', 'icon')) {
                $table->string('icon')->nullable()->change();
            } else {
                $table->string('icon')->nullable();
            }
            if (!Schema::hasColumn('facilities', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('facilities', 'category')) {
                $table->string('category')->nullable()->after('name');
            }
            if (!Schema::hasColumn('facilities', 'capacity')) {
                $table->integer('capacity')->nullable()->after('category');
            }
            if (!Schema::hasColumn('facilities', 'location')) {
                $table->string('location')->nullable()->after('capacity');
            }
            if (!Schema::hasColumn('facilities', 'status')) {
                $table->string('status')->default('active')->after('location');
            }
            if (!Schema::hasColumn('facilities', 'features')) {
                $table->json('features')->nullable()->after('status');
            }
            if (!Schema::hasColumn('facilities', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('features');
            }
            if (!Schema::hasColumn('facilities', 'operating_hours')) {
                $table->string('operating_hours')->nullable()->after('contact_person');
            }
            if (!Schema::hasColumn('facilities', 'image')) {
                $table->string('image')->nullable()->after('icon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            if (Schema::hasColumn('facilities', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('facilities', 'operating_hours')) {
                $table->dropColumn('operating_hours');
            }
            if (Schema::hasColumn('facilities', 'contact_person')) {
                $table->dropColumn('contact_person');
            }
            if (Schema::hasColumn('facilities', 'features')) {
                $table->dropColumn('features');
            }
            if (Schema::hasColumn('facilities', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('facilities', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('facilities', 'capacity')) {
                $table->dropColumn('capacity');
            }
            if (Schema::hasColumn('facilities', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('facilities', 'name')) {
                $table->dropColumn('name');
            }
            // can't revert icon nullability safely without data loss context
        });
    }
};
