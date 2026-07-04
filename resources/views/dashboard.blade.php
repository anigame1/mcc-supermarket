@extends('layouts.app')

@section('title', 'Dashboard | MCC Supermarket')
@section('page-title', 'MCC SUPERMARKET DASHBOARD')

@section('content')
<div class="dashboard-row">
    <div class="dashboard-box box-users">
        <i class="fa-solid fa-users"></i>
        <h3>Total Users</h3>
        <p>{{ $totalUsers }}</p>
    </div>

    <div class="dashboard-box box-sales">
        <i class="fa-solid fa-dollar-sign"></i>
        <h3>Total Sales Today</h3>
        <p>${{ number_format($totalSalesToday, 2) }}</p>
    </div>

    <div class="dashboard-box box-about">
        <i class="fa-solid fa-circle-info"></i>
        <a href="{{ route('about') }}">About</a>
    </div>

    <div class="dashboard-box box-contact">
        <i class="fa-solid fa-phone"></i>
        <a href="{{ route('contact') }}">Contact</a>
    </div>
</div>

<div class="summary-section">
    <h2><i class="fa-solid fa-chart-line"></i> Quick Summary</h2>
    <div class="summary-items">
        <div class="summary-card"><i class="fa-solid fa-user-plus"></i> New Users Today: <strong>{{ $newUsersToday }}</strong></div>
        <div class="summary-card"><i class="fa-solid fa-cart-shopping"></i> Orders Today: <strong>{{ $ordersToday }}</strong></div>
        <div class="summary-card"><i class="fa-solid fa-money-bill"></i> Weekly Revenue: <strong>${{ number_format($weeklyRevenue, 2) }}</strong></div>
    </div>
</div>

<div class="sales-table">
    <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Sales</h2>
    <table>
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentSales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->user->name }}</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                    <td>{{ ucfirst($sale->method) }}</td>
                    <td>{{ $sale->date->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No sales yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="chart-section">
    <div class="chart-box">
        <h2><i class="fa-solid fa-chart-column"></i> Weekly Sales Overview</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="chart-box">
        <h2><i class="fa-solid fa-chart-pie"></i> Payment Method Breakdown</h2>
        <canvas id="methodChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesCtx = document.getElementById('salesChart');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($weeklySales->pluck('label')) !!},
            datasets: [{
                label: 'Sales (USD)',
                data: {!! json_encode($weeklySales->pluck('total')) !!},
                backgroundColor: '#3498db',
                borderRadius: 6
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    const methodCtx = document.getElementById('methodChart');
    new Chart(methodCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($methodBreakdown->keys()->map(fn($m) => ucfirst($m))) !!},
            datasets: [{
                data: {!! json_encode($methodBreakdown->values()) !!},
                backgroundColor: ['#1abc9c', '#f39c12', '#9b59b6']
            }]
        }
    });
</script>
@endpush
