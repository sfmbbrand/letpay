<?php

/** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayNequiResponse extends LetPayResponseBase
{
    /**
     * QR code image (base64 encoded).
     */
    public ?string $qr_code = null;

    /**
     * QR code raw text.
     */
    public ?string $qr_code_text = null;

    /**
     * Deep link to Nequi app.
     */
    public ?string $redirect_url = null;

    /**
     * Expiration date for the payment.
     */
    public ?string $expiration_date = null;

    public string $error;
}
