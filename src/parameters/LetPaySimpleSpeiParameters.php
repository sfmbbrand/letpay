<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleSpeiParameters
{
    // required
    public float $amount;
    public string $contract_id = '';
    public string $reference_id;
    public string $notification_url;
    public LetPaySimplePerson $person;
    public LetPaySimpleSpeiPaymentParameters $payment;

    // Optional
    public string $asset = 'MXN'; // BRL, USD, EUR
    public ?object $extra_data;
    public ?string $ip_address; // IPv4/IPv6

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
