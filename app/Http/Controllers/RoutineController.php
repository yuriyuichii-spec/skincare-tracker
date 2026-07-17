<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RoutineLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RoutineController extends Controller
{
    /**
     * Show today's skincare checklist (pagi & malam).
     */
    public function today()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $morningProducts = Product::where('user_id', $userId)
            ->whereIn('time_of_use', ['pagi', 'keduanya'])
            ->orderBy('name')
            ->get();

        $eveningProducts = Product::where('user_id', $userId)
            ->whereIn('time_of_use', ['malam', 'keduanya'])
            ->orderBy('name')
            ->get();

        $logsToday = RoutineLog::where('user_id', $userId)
            ->whereDate('date', $today)
            ->get()
            ->keyBy(function ($log) {
                return $log->product_id . '_' . $log->time_of_day;
            });

        $reminders = Product::where('user_id', $userId)
            ->whereNotNull('expiry_date')
            ->get()
            ->filter(function ($product) {
                return $product->isExpired() || $product->isExpiringSoon();
            });

        return view('routine.today', compact(
            'morningProducts',
            'eveningProducts',
            'logsToday',
            'reminders',
            'today'
        ));
    }

    /**
     * Toggle a product's "done" status for today's routine.
     */
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'time_of_day' => ['required', 'in:pagi,malam'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $log = RoutineLog::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'date' => Carbon::today(),
            'time_of_day' => $validated['time_of_day'],
        ]);

        $log->is_done = !$log->is_done;
        $log->save();

        return back()->with('success', 'Checklist diperbarui!');
    }

    /**
     * Show a monthly calendar view of routine completion history.
     */
    public function calendar(Request $request)
    {
        $userId = Auth::id();
        $month = (int) $request->query('month', Carbon::now()->month);
        $year = (int) $request->query('year', Carbon::now()->year);

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $products = Product::where('user_id', $userId)->get();

        $required = [];
        foreach ($products as $product) {
            if (in_array($product->time_of_use, ['pagi', 'keduanya'])) {
                $required[] = $product->id . '_pagi';
            }
            if (in_array($product->time_of_use, ['malam', 'keduanya'])) {
                $required[] = $product->id . '_malam';
            }
        }

        $logsByDate = RoutineLog::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->where('is_done', true)
            ->get()
            ->groupBy(fn ($log) => $log->date->toDateString());

        $days = [];
        $cursor = $startOfMonth->copy();

        while ($cursor->lte($endOfMonth)) {
            $doneToday = ($logsByDate->get($cursor->toDateString()) ?? collect())
                ->map(fn ($log) => $log->product_id . '_' . $log->time_of_day)
                ->toArray();

            $doneCount = count(array_intersect($required, $doneToday));
            $totalCount = count($required);

            if ($cursor->isFuture()) {
                $status = 'future';
            } elseif ($totalCount === 0) {
                $status = 'empty';
            } elseif ($doneCount === $totalCount) {
                $status = 'complete';
            } elseif ($doneCount > 0) {
                $status = 'partial';
            } else {
                $status = 'missed';
            }

            $days[] = [
                'date' => $cursor->copy(),
                'status' => $status,
            ];

            $cursor->addDay();
        }

        $prevMonth = $startOfMonth->copy()->subMonth();
        $nextMonth = $startOfMonth->copy()->addMonth();

        return view('routine.calendar', compact('days', 'startOfMonth', 'prevMonth', 'nextMonth'));
    }
}
