<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RoutineLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with product stats and routine streak.
     */
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $totalProducts = Product::where('user_id', $userId)->count();

        $requiredToday = $this->requiredSessionsForDate($userId, $today);
        $totalRequiredToday = count($requiredToday);

        $doneToday = RoutineLog::where('user_id', $userId)
            ->whereDate('date', $today)
            ->where('is_done', true)
            ->count();

        $streak = $this->calculateStreak($userId);

        return view('dashboard', compact(
            'totalProducts',
            'doneToday',
            'totalRequiredToday',
            'streak'
        ));
    }

    /**
     * Get list of "product_id_timeofday" strings required for a given date.
     */
    private function requiredSessionsForDate(int $userId, Carbon $date): array
    {
        $products = Product::where('user_id', $userId)->get();
        $sessions = [];

        foreach ($products as $product) {
            if (in_array($product->time_of_use, ['pagi', 'keduanya'])) {
                $sessions[] = $product->id . '_pagi';
            }
            if (in_array($product->time_of_use, ['malam', 'keduanya'])) {
                $sessions[] = $product->id . '_malam';
            }
        }

        return $sessions;
    }

    /**
     * Check whether all required routine sessions were completed on a given date.
     */
    private function isDayComplete(int $userId, Carbon $date): bool
    {
        $required = $this->requiredSessionsForDate($userId, $date);

        if (count($required) === 0) {
            return false;
        }

        $doneSessions = RoutineLog::where('user_id', $userId)
            ->whereDate('date', $date)
            ->where('is_done', true)
            ->get()
            ->map(fn ($log) => $log->product_id . '_' . $log->time_of_day)
            ->toArray();

        foreach ($required as $session) {
            if (!in_array($session, $doneSessions)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate the current consecutive-day streak of fully completed routines.
     */
    private function calculateStreak(int $userId): int
    {
        $streak = 0;
        $date = Carbon::today();

        if ($this->isDayComplete($userId, $date)) {
            $streak++;
        }

        $date = $date->copy()->subDay();

        for ($i = 0; $i < 365; $i++) {
            if ($this->isDayComplete($userId, $date)) {
                $streak++;
                $date = $date->copy()->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}
