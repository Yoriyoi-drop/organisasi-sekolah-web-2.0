<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organization_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('pembina');
            $table->timestamps();
            $table->unique(['organization_id', 'teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_teacher');
    }
};
