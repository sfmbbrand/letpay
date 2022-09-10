<?php /** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayErrorResponse
{

    public string $timestamp;
    public ?int $status; // 422 => Unprocessable Entity, 500 => Internal Server Error, 502 => Bad Gateway
    public string $error = '';
    public string $exception;
    public string $message = '';
    public string $path;

    public function __construct(object $json)
    {
        foreach ($json as $k => $v)
            $this->$k = $v;
    }

}
