<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayBankTransferPaymentParameters
{

    public float $amount;
    public string $asset; // CLP, COP
    public string $country; // CL, CO
    public string $currency; // CLP, COP
    public LetPayBankTransferPaymentBankTransferParameters $bank_transfer;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
