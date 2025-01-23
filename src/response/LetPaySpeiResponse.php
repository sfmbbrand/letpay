<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPaySpeiResponse extends LetPayResponseBase
{
    public string $pdf_gzip_base_64;
    public string $clabe;
    public string $error;

}
