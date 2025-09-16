<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayBankTransferParameters
{
    // required
    public string $contract_id = '';
    public string $notification_url;
    public string $reference_id;
    public LetPayBankTransferPaymentParameters $payment;
    public LetPayBankTransferPerson $person;

    // Optional
    public ?string $ip_address; // IPv4/IPv6
    public ?string $return_url;
    public ?object $extra_data;
    public ?LetPayAddress $address;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
