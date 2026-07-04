<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $selectedDate = $request->query('date') ?: Carbon::today()->toDateString();
        $dayOfWeek = Carbon::parse($selectedDate)->format('l');

        $paymentsForDay = Payment::whereDate('date', $selectedDate);

        $totalSales = (clone $paymentsForDay)->sum('total');
        $totalPayments = (clone $paymentsForDay)->count();

        $topBuyers = Payment::with('user')
            ->whereDate('date', $selectedDate)
            ->selectRaw('user_id, SUM(total) as total_spent, COUNT(*) as purchases')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        $allPayments = Payment::with('user')
            ->whereDate('date', $selectedDate)
            ->orderByDesc('date')
            ->get();

        $topProducts = PaymentItem::with('product')
            ->whereHas('payment', fn ($query) => $query->whereDate('date', $selectedDate))
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(quantity * price) as total_amount')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.reports.index', [
            'selectedDate' => $selectedDate,
            'dayOfWeek' => $dayOfWeek,
            'totalSales' => $totalSales,
            'totalPayments' => $totalPayments,
            'topBuyers' => $topBuyers,
            'allPayments' => $allPayments,
            'topProducts' => $topProducts,
        ]);
    }
}
