<?php /** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayPaymentStatusResponse
{
    public string $refresh_token;
    public string $paymentToken;
    public string $paymentStatus;
    public string $createdAt;
    public string $currency;
    public float $amount_received;
    public string $errorCode;
    public ?object $extra_data;
    public ?object $cancellation_details; // only for cancelled payment

    public function __construct(object $json)
    {
        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
