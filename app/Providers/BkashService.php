<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class BkashService extends ServiceProvider
{
    protected $config;

    public function __construct()
    {
        $this->config = config('bkash');
    }

    protected function baseUrl()
    {
        return $this->config['mode'] === 'sandbox'
            ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/'
            : 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/';
    }

    public function getToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'username' => $this->config['username'],
            'password' => $this->config['password'],
        ])->post($this->baseUrl() . 'checkout/token/grant', [
            'app_key' => $this->config['app_key'],
            'app_secret' => $this->config['app_secret'],
        ]);

        Log::info('Bkash Token Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            $token = $response->json('id_token', '');
            Session::put('bkash_token', $token);
            return $token;
        }

        Log::error('Bkash token request failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    public function createPayment($amount)
    {
        $token = $this->getToken();
        if (!$token) {
            Log::error('Bkash token not received. Cannot create payment.');
            return null;
        }

        $payload = [
            'mode' => '0011',
            'payerReference' => 'user001',
            'callbackURL' => $this->config['callback'],
            'amount' => number_format($amount, 2, '.', ''),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv" . now()->format('YmdH') . rand(1000, 9999),
        ];

        Log::info('Bkash Create Payment Request', $payload);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->config['app_key'],
        ])->withBody(json_encode($payload), 'application/json')
          ->post($this->baseUrl() . 'checkout/create');

        if ($response->successful()) {
            Log::info('Bkash Create Payment Success', ['body' => $response->body()]);
            return $response->json('bkashURL', '');
        }

        Log::error('Bkash createPayment failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    public function execute($paymentID)
    {
        $token = Session::get('bkash_token');
        if (!$token) {
            Log::error('Bkash execute failed - no token found in session.');
            return null;
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->config['app_key'],
        ])->post($this->baseUrl() . 'checkout/execute', [
            'paymentID' => $paymentID,
        ]);

        return $response->json();
    }

    public function query($paymentID)
    {
        $token = Session::get('bkash_token');
        if (!$token) {
            Log::error('Bkash query failed - no token in session.');
            return null;
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
            'X-APP-Key' => $this->config['app_key'],
        ])->post($this->baseUrl() . 'checkout/payment/status', [
            'paymentID' => $paymentID,
        ]);

        return $response->json();
    }

    public function callback(array $request)
    {
        return $this->execute($request['paymentID']);
    }
}
