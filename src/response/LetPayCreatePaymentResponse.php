<?php

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPayCreatePaymentResponse
{
    public string $refresh_token;
    public array $methods; // ["CREDITCARD", "BOLETO", "PIX"]
    public LetPayPayment $payment;
    public LetPayTotals $totals;
    public object $customer_fees;
    public array $installments;

    public function __construct(object $json)
    {
        $this->refresh_token = $json->refresh_token;
        $this->methods = $json->methods;
        $this->payment = new LetPayPayment($json->payment);
        $this->totals = new LetPayTotals($json->totals);
        $this->customer_fees = $json->customer_fees;
        $this->installments = $json->installments;
    }
}

class LetPayPayment
{
    public string $payment_token;

    public function __construct(object $json)
    {
        $this->payment_token = $json->payment_token;
    }
}
