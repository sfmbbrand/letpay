<?php /** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayPicPayResponse extends LetPayResponseBase
{
    public string $qr_code;
    public string $expiration_date;
    public string $error;

}
