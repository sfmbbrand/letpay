<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePicPayParameters
{
    public string $contract_id = '';
    public string $reference_id;
    public string $notification_url;
    public ?string $ip_address; // IPv4/IPv6
    public LetPaySimplePicPayPaymentParameters $payment;
    public LetPaySimplePerson $person;
    public ?object $extra_data;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
