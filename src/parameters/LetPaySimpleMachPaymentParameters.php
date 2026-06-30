<?php

/** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleMachPaymentParameters
{
    public float $amount;

    /** Asset reference code for the sale's amount (ISO-4217). */
    public string $asset = 'CLP';

    /** Currency in ISO-4217 format. */
    public string $currency = 'CLP';

    /** Country in ISO 3166-2 format. */
    public string $country = 'CL';

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
