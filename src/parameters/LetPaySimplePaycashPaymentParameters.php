<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePaycashPaymentParameters extends LetPaySimplePaymentParameters
{
    public object $paycash; // expiration_date, line1, line2, line3
}
