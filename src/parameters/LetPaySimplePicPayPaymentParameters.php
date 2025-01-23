<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePicPayPaymentParameters
{
    public float $amount;
    /**
     * Reference code for asset for the sale's amount
     * @var string|null $asset
     */
    public ?string $asset = 'BRL';
    /**
     * To pre-authorize payment for later capture. Default: false.
     * Pre-auth capture/cancellation has a TTL of 5 days
     * @var bool $delay_capture
     */
    public bool $delay_capture = false;
    /**
     * Currency code in ISO-4217 format. Default: BRL
     * @var string $currency
     */
    public string $currency = 'BRL';
    /**
     * Country code in ISO 3166-2 format. Default: BR
     * @var string $country
     */
    public string $country = 'BR';
    public ?PicPay $picpay;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }
}

class PicPay
{
    /**
     * Optional. YYYY-MM-DD. Default is 2 days from current date
     * @var string|null $expiration_date
     */
    public ?string $expiration_date;
}