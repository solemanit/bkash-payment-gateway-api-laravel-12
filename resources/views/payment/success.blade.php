@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow rounded-4 border-success">
            <div class="card-header bg-success text-white text-center rounded-top-4">
                <h4 class="mb-0">✅ Payment Successful</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-center text-muted">Thank you for your payment! Below is your transaction receipt:</p>

                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light">Transaction ID</th>
                            <td>{{ $payment['trxID'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Payment ID</th>
                            <td>{{ $payment['paymentID'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Amount</th>
                            <td><strong>{{ $payment['amount'] ?? 'N/A' }} BDT</strong></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Invoice No</th>
                            <td>{{ $payment['merchantInvoiceNumber'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Date</th>
                            <td>{{ $payment['paymentExecuteTime'] ? \Carbon\Carbon::parse($payment['paymentExecuteTime'])->format('d M Y, h:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($payment['transactionStatus'] ?? 'N/A') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('payment.form') }}" class="btn btn-outline-success">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection
