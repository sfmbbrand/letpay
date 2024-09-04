<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPayPaycashResponse
{
    public string $refresh_token;
    public string $payment_token;
    public string $payment_status;
    public string $error;
    public ?string $customer_id;
    public string $paycash_html;
    public string $paycash_code;
    public string $paycash_duedate; // (date: YYYY-MM-DD)
    public float $paycash_amount;
    public string $pix_qr_code;
    public string $pix_code;
    public LetPayTotals $totals;
    public object $customer_fees;

    public function __construct(object $json)
    {
        $json->totals = new LetPayTotals($json->totals);

        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
