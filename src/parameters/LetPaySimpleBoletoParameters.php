<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleBoletoParameters
{
    // required
    public float $amount;
    public string $contract_id = '';
    public LetPaySimplePerson $person;
    public LetPaySimpleBoletoPaymentParameters $payment;
    public string $tax_id; // Unique identifier for this person in country tax system (e.g. in Brazil: CPF)
    public string $email;

    // Optional
    public ?string $notification_url;
    public string $asset = 'BRL'; // BRL, USD, EUR
    public ?string $reference_id;
    public ?object $extra_data;
    public ?string $ip_address; // IPv4/IPv6

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;

    }
}
