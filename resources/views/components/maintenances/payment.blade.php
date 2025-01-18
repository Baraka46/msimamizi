@extends('layouts.app')

@section('content')
<h1>Payments for {{ $maintenance->expense_name }}</h1>
<p>Car: {{ $maintenance->car->name }}</p>
<p>Cost: {{ $maintenance->cost }}</p>
<p>Outstanding Balance: {{ $maintenance->outstanding_balance }}</p>

<table>
    <thead>
        <tr>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
        <tr>
            <td>{{ $payment->amount }}</td>
            <td>{{ $payment->payment_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
