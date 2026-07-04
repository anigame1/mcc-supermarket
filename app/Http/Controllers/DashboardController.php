<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        $totalUsers = User::count();

        $totalSalesToday = Payment::whereDate('date', $today)->sum('total');
        $newUsersToday = User::whereDate('created_at', $today)->count();
        $ordersToday = Payment::whereDate('date', $today)->count();

        $weeklyRevenue = Payment::whereBetween('date', [
            $today->copy()->startOfWeek(),
            $today->copy()->endOfWeek(),
        ])->sum('total');

        $recentSales = Payment::with('user')->latest('date')->take(5)->get();

        $weeklySales = collect(range(6, 0))->map(function (int $daysAgo) {
            $day = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $day->format('D'),
                'total' => (float) Payment::whereDate('date', $day)->sum('total'),
            ];
        });

        $methodBreakdown = Payment::selectRaw('method, count(*) as total')
            ->groupBy('method')
            ->pluck('total', 'method');

        return view('dashboard', [
            'totalUsers' => $totalUsers,
            'totalSalesToday' => $totalSalesToday,
            'newUsersToday' => $newUsersToday,
            'ordersToday' => $ordersToday,
            'weeklyRevenue' => $weeklyRevenue,
            'recentSales' => $recentSales,
            'weeklySales' => $weeklySales,
            'methodBreakdown' => $methodBreakdown,
        ]);
    }
}
