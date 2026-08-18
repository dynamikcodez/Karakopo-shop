<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Initialize payment and return the authorization URL.
     */
    public function initialize(Order $order): string;

    /**
     * Verify the payment using the reference.
     * Returns true if successful, false otherwise.
     */
    public function verify(string $reference): bool;
}
