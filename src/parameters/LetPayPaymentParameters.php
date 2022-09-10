<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayPaymentParameters
{
    // required
    public float $amount;
    public string $asset; // BRL, USD, EUR
    public string $reference_id;
    public string $contract_id = '';
    public string $person_firstname;
    public string $person_surname;
    public string $person_taxid; // Unique identifier for this person in country tax system (e.g. in Brazil: CPF)
    public string $person_email;
    public string $person_birth;

    // required if !disable_address
    public ?string $address_main;
    public ?int $address_number;
    public ?string $address_locality;
    public ?string $address_city;
    public ?string $address_state;
    public ?string $address_country;
    public ?string $address_zipcode;
    public ?string $address_phone_area;
    public ?string $phone_country;
    public ?string $phone;

    // Optional
    public ?bool $disable_address = false;
    public ?string $notification_url;
    public ?object $extra_data;
    public ?string $soft_descriptor;
    public ?string $ip_address; // IPv4/IPv6

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }

}
