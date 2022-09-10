<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimpleBoletoPaymentParameters extends LetPaySimplePaymentParameters
{
    public object $boleto; // expiration_date, line1, line2, line3
}
