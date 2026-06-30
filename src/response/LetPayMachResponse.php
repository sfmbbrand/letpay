<?php

/** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayMachResponse extends LetPayResponseBase
{
    /** Base64-encoded gzip-compressed PNG of the QR code to scan. */
    public ?string $qr_code = null;

    /** Deep link that opens the MACH app to complete the payment. */
    public ?string $app_link = null;

    /** ISO 8601 expiration timestamp for the QR / payment. */
    public ?string $expiration_date = null;

    /** User-facing payment steps returned by LetPay. */
    public ?array $instructions = null;

    public string $error;
}
