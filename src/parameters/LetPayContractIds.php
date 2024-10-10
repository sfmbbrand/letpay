<?php

namespace LetPay\parameters;

class LetPayContractIds
{
    public string $pix;
    public string $boleto;
    public string $oxxo;
    public string $paycash;
    public string $spei;
    public string $paynet;

    public function __construct(object $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}
