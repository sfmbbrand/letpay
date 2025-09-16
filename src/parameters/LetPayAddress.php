<?php

namespace LetPay\parameters;

class LetPayAddress
{
    public string $city;
    public string $phone_country;
    public string $phone_area;
    public string $phone;

    // optional
    public ?string $main;
    public ?string $number;
    public ?string $additional;
    public ?string $locality;
    // ... https://developer.letpay.co/docs/payments/colombia/bank-transfer/


    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }

}