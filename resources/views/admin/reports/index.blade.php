@extends('layouts.app')

@section('title', 'Daily System Report | MCC Supermarket')
@section('page-title', 'DAILY SYSTEM REPORT')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/report.css') }}">
@endpush

@section('content')
<div class="date-filter">
    <input type="date" id="datePicker" value="{{ $selectedDate }}">
    <div class="day-badge">{{ $dayOfWeek }}</div>
</div>

<div class="stats">
    <div class="card">
        <h3>Total Sales</h3>
        <p>${{ number_format($totalSales, 2) }}</p>
    </div>
    <div class="card">
        <h3>Total Payments</h3>
        <p>{{ $totalPayments }}</p>
    </div>
</div>

<h2>🏆 Top Buyers</h2>
@if ($topBuyers->count() > 0)
<table>
    <tr><th>Name</th><th>Email</th><th>Total Spent ($)</th><th>Purchases</th></tr>
    @foreach ($topBuyers as $row)
    <tr>
        <td>{{ $row->user->name }}</td>
        <td>{{ $row->user->email }}</td>
        <td>{{ number_format($row->total_spent, 2) }}</td>
        <td>{{ $row->purchases }}</td>
    </tr>
    @endforeach
</table>
@else
<p style="text-align:center;">No buyers on this day.</p>
@endif

<h2>🧾 All Payments</h2>
@if ($allPayments->count() > 0)
<table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Total ($)</th><th>Method</th><th>Date</th></tr>
    @foreach ($allPayments as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->user->name }}</td>
        <td>{{ $row->user->email }}</td>
        <td>{{ number_format($row->total, 2) }}</td>
        <td>{{ $row->method }}</td>
        <td>{{ $row->date->format('Y-m-d H:i:s') }}</td>
    </tr>
    @endforeach
</table>
@else
<p style="text-align:center;">No payments on this day.</p>
@endif

<h2>📦 Top Products</h2>
@if ($topProducts->count() > 0)
<table>
    <tr><th>Product</th><th>Units Sold</th><th>Total Amount ($)</th></tr>
    @foreach ($topProducts as $row)
    <tr>
        <td>{{ $row->product->name }}</td>
        <td>{{ $row->total_sold }}</td>
        <td>{{ number_format($row->total_amount, 2) }}</td>
    </tr>
    @endforeach
</table>
@else
<p style="text-align:center;">No products sold yet.</p>
@endif

@endsection

@push('scripts')
<script>
document.getElementById('datePicker').addEventListener('change', function () {
    window.location.href = '{{ route('admin.reports.index') }}?date=' + this.value;
});
</script>
@endpush
