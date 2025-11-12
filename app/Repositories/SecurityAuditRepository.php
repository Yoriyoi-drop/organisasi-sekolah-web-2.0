<?php

namespace App\Repositories;

use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class SecurityAuditRepository
{
    /**
     * Nama tag untuk entri cache respons.
     */
    const CACHE_TAG = 'security-audit';

    public function __construct()
    {
        // Tetapkan tag cache dalam konfigurasi Spatie ResponseCache
        config(['responsecache.cache_tag' => self::CACHE_TAG]);
    }

    /**
     * Dapatkan log keamanan yang dipaginasi dengan filter
     */
    public function getPaginatedLogs(array $filters = []): LengthAwarePaginator
    {
        $query = SecurityLog::with('user')
            ->when(isset($filters['user_id']), function (Builder $query) use ($filters) {
                $query->where('user_id', $filters['user_id']);
            })
            ->when(isset($filters['ip_address']), function (Builder $query) use ($filters) {
                $query->where('ip_address', 'like', "%{$filters['ip_address']}%");
            })
            ->when(isset($filters['status']), function (Builder $query) use ($filters) {
                // status disimpan di dalam kolom JSON 'data'
                $query->whereJsonContains('data', ['status' => $filters['status']]);
            })
            ->when(isset($filters['action']), function (Builder $query) use ($filters) {
                $query->where('action', $filters['action']);
            })
            ->when(isset($filters['risk_level']), function (Builder $query) use ($filters) {
                $query->where('risk_level', $filters['risk_level']);
            })
            ->when(isset($filters['date_from']), function (Builder $query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            })
            ->when(isset($filters['date_to']), function (Builder $query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            })
            ->orderBy('created_at', 'desc');

        return $query->paginate(15);
    }

    /**
     * Dapatkan statistik ringkasan untuk dashboard keamanan
     */
    public function getSummaryStats(): array
    {
        $today = Carbon::today();

        return [
            'total_otp_attempts' => SecurityLog::where('action', 'like', 'otp%')->count(),
            // Hitung verifikasi otp yang gagal tetapi kecualikan acara berisiko tinggi secara eksplisit
            'failed_verifications' => SecurityLog::where('action', 'otp_verify')
                ->whereJsonContains('data', ['status' => 'error'])
                ->where('risk_level', '<>', 'high')
                ->count(),
            'locked_accounts' => User::where('locked_until', '>', now())->count(),
            'today_events' => SecurityLog::whereDate('created_at', $today)->count(),
            'high_risk_events' => SecurityLog::where('risk_level', 'high')
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count(),
        ];
    }

    /**
     * Dapatkan daftar jenis acara unik untuk penyaringan
     */
    public function getEventTypes(): array
    {
        return SecurityLog::select('action')
            ->distinct()
            ->pluck('action')
            ->toArray();
    }

    /**
     * Dapatkan acara berisiko tinggi terbaru
     */
    public function getRecentHighRiskEvents(int $limit = 5): array
    {
        return SecurityLog::with('user')
            ->where('risk_level', 'high')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
