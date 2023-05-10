<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPayBoletoResponse
{
    public string $refresh_token;
    public string $payment_token;
    public string $payment_status;
    public string $error;
    public ?string $customer_id;
    public string $boleto_html;
    public string $boleto_code;
    public string $boleto_duedate; // (date: YYYY-MM-DD)
    public float $boleto_amount;
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
