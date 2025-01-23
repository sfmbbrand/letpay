<?php /** @noinspection PhpUnused */

namespace LetPay\response;

use LetPay\parameters\LetPayTotals;

abstract class LetPayResponseBase
{
    public string $transaction_status;
    public string $payment_token;
    public string $reference_id;
    public string $amount;
    public string $refresh_token;
    public LetPayTotals $totals;
    public ?object $customer_fees;

    public function __construct(object $json)
    {
        $json->totals = new LetPayTotals($json->totals);

        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
