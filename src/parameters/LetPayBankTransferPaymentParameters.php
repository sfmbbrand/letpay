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
        if (isset($params['bank_transfer']))
            $params['bank_transfer'] = new LetPayBankTransferPaymentBankTransferParameters($params['bank_transfer']);

        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
