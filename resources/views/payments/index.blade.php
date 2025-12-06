@extends('layouts.Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Payments</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->student?->first_name }} {{ $payment->student?->last_name }}</td>
                    <td>Rs.{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->recorded_by }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
