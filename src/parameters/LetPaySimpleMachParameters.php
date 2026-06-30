<?php

/** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleMachParameters
{
    public string $contract_id = '';
    public string $reference_id;
    public string $notification_url;
    public ?string $ip_address = null;
    public LetPaySimpleMachPaymentParameters $payment;
    public LetPaySimplePerson $person;
    public ?object $extra_data = null;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
