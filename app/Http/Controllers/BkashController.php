<?php

namespace App\Http\Controllers;

use App\Providers\BkashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BkashController extends Controller
{
    protected $bkash;

    public function __construct(BkashService $bkash)
    {
        $this->bkash = $bkash;
    }

    public function showForm()
    {
        return view('payment.form');
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $url = $this->bkash->createPayment($request->amount);

        if (!$url) {
            Log::error('Failed to create bKash payment URL.');
            return back()->withErrors(['payment' => 'Failed to create payment URL.']);
        }

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $paymentID = $request->query('paymentID');

        // Execute payment
        $executeData = $this->bkash->execute($paymentID);
        Log::info('Bkash Execute Response', ['execute_data' => $executeData]);

        // Check for success
        if (
            isset($executeData['transactionStatus']) &&
            $executeData['transactionStatus'] === 'Completed'
        ) {
            return view('payment.success', ['payment' => $executeData]);
        }

        // Fallback: failed
        return view('payment.failed', ['error' => $executeData]);
    }

}
