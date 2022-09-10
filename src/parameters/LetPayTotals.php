<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayTotals
{
    public float $amount;
    public float $original_amount;
    public string $original_asset;
    public float $customer_fees;
    public float $customer_amount;
    public string $asset;

    public function __construct(object $json)
    {
        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
