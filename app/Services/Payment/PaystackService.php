<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaystackService implements PaymentGatewayInterface
{
    protected $secretKey;
    protected $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
    }

    public function initialize(Order $order): string
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->baseUrl . '/transaction/initialize', [
                'email' => $order->customer_email,
                'amount' => $order->total * 100, // Paystack uses kobo
                'reference' => $order->order_number,
                'callback_url' => route('checkout.verify'),
                'metadata' => [
                    'order_id' => $order->id,
                ]
            ]);

        if ($response->successful() && $response->json('status')) {
            return $response->json('data.authorization_url');
        }

        throw new \Exception('Paystack initialization failed: ' . $response->body());
    }

    public function verify(string $reference): bool
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->baseUrl . '/transaction/verify/' . $reference);

        if ($response->successful() && $response->json('status')) {
            return $response->json('data.status') === 'success';
        }

        return false;
    }
}
