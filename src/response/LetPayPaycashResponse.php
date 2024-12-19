<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPayPaycashResponse
{
    public string $amount;
    public string $barcode;
    public string $barcode_png_gzip_base_64;
    public object $customer_fees;
    public string $instructions_link;
    public string $payment_status;
    public string $payment_token;
    public string $reference_id;
    public string $refresh_token;
    public LetPayTotals $totals;
    public string $transaction_status;
    public string $error;

    public function __construct(object $json)
    {
        $json->totals = new LetPayTotals($json->totals);

        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
