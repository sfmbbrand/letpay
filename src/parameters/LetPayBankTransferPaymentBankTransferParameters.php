<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayBankTransferPaymentBankTransferParameters
{

    public string $description;
    public string $bank_code; // Only used in Colombia

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
