@extends('layouts.app')

@section('title', 'bKash Payment')

@section('content')
    <div class="card shadow rounded-4 p-4 mx-auto" style="max-width: 500px;">
        <h4 class="mb-3 text-center">bKash Payment</h4>
        <p class="text-muted text-center mb-4">Enter the amount and proceed to pay securely via bKash.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">৳</span>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1">
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-pink btn-lg">
                    <img src="https://pgw-integration.bkash.com/img/only-logo.78463dd4.png" alt="bKash Logo" width="24" class="me-2"> Pay with bKash
                </button>
                <p class="text-center mt-3" style="font-size: 14px"><a style="color: gray; text-decoration: none" href="https://github.com/solemanit">Developed by Soleman IT</a></p>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .btn-pink {
        background-color: #E2136E;
        border-color: #E2136E;
        color: #fff;
    }
    .btn-pink:hover {
        background-color: #c01160;
        border-color: #b0105a;
        color: #fff;
    }
</style>
@endpush
