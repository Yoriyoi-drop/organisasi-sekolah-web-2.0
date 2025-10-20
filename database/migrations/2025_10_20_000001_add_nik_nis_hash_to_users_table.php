<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\SecurityService;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik_hash')->nullable()->unique()->after('nis');
            $table->string('nis_hash')->nullable()->unique()->after('nik_hash');
        });

        // Backfill existing users
        $users = DB::table('users')->select('id', 'nik', 'nis')->get();
        foreach ($users as $user) {
            $nikPlain = $user->nik ? SecurityService::decryptSensitiveField($user->nik) : null;
            $nisPlain = $user->nis ? SecurityService::decryptSensitiveField($user->nis) : null;
            $nikHash = $nikPlain ? hash('sha256', self::normalizeId($nikPlain)) : null;
            $nisHash = $nisPlain ? hash('sha256', self::normalizeId($nisPlain)) : null;
            DB::table('users')->where('id', $user->id)->update([
                'nik_hash' => $nikHash,
                'nis_hash' => $nisHash,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nik_hash']);
            $table->dropUnique(['nis_hash']);
            $table->dropColumn(['nik_hash', 'nis_hash']);
        });
    }

    private static function normalizeId(?string $value): string
    {
        if (!$value) return '';
        // Normalize: trim and remove non-alphanumerics except digits and letters
        $value = trim($value);
        return preg_replace('/[^A-Za-z0-9]/', '', $value);
    }
};
