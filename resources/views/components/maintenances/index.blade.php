<x-app-layout>

<h1>Maintenances</h1>
<table>
    <thead>
        <tr>
            <th>Car</th>
            <th>Expense Name</th>
            <th>Cost</th>
            <th>Outstanding Balance</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($maintenances as $maintenance)
        <tr>
            <td>{{ $maintenance->car->plate_number }}</td>
            <td>{{ $maintenance->expense_name }}</td>
            <td>{{ $maintenance->cost }}</td>
            <td>{{ $maintenance->outstanding_balance }}</td>
            <td>{{ $maintenance->date }}</td>
            <td>
                <a href="{{ route('maintenances.viewPayments', $maintenance) }}">View Payments</a>
                <form method="POST" action="{{ route('maintenances.addPayment', $maintenance) }}">
                    @csrf
                    <input type="number" name="amount" placeholder="Payment Amount" required>
                    <input type="date" name="payment_date" required>
                    <button type="submit">Add Payment</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


</x-app-layout>
