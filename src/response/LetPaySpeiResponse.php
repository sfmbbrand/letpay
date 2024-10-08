<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

class LetPaySpeiResponse
{
    public string $transaction_status;
    public string $payment_token;
    public string $reference_id;
    public string $pdf_gzip_base_64;
    public string $clabe;
    public string $amount;
    public string $refresh_token;
    public LetPayTotals $totals;
    public ?object $customer_fees;
    public string $error;

    public function __construct(object $json)
    {
        $json->totals = new LetPayTotals($json->totals);

        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
