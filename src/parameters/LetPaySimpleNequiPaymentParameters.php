<?php

/** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleNequiPaymentParameters
{
    public float $amount;

    /**
     * Reference code for asset for the sale's amount.
     *
     * @var string $asset
     */
    public string $asset = 'COP';

    /**
     * Currency code in ISO-4217 format. Default: COP.
     *
     * @var string $currency
     */
    public string $currency = 'COP';

    /**
     * Country code in ISO 3166-2 format. Default: CO.
     *
     * @var string $country
     */
    public string $country = 'CO';

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
