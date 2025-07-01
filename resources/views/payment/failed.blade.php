@extends('layouts.app')

@section('title', 'bKash Payment Failed')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-danger shadow rounded-4">
            <div class="card-header bg-danger text-white text-center rounded-top-4">
                <h4 class="mb-0">❌ Payment Failed</h4>
            </div>
            <div class="card-body text-center">
                <p class="text-muted mb-3">Unfortunately, your payment could not be completed.</p>
                <p class="fw-semibold text-danger">Please try again or contact support if the issue persists.</p>

                <div class="mt-4">
                    <a href="{{ route('payment.form') }}" class="btn btn-outline-danger me-2">
                        🔁 Try Again
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        🏠 Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
