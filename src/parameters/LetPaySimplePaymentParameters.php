<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePaymentParameters
{
    public float $amount;
    public string $asset; // BRL, USD, EUR
    public ?string $soft_descriptor;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
