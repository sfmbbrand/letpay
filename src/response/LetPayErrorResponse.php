<?php
/**
 * @noinspection PhpMultipleClassesDeclarationsInOneFile
 * @noinspection PhpUnused
 */

namespace LetPay\response;

class LetPayErrorResponse
{

    public string $timestamp;
    public ?int $status; // 422 => Unprocessable Entity, 500 => Internal Server Error, 502 => Bad Gateway
    public string $error = '';
    /** @var LetPayErrorResponseItem[] $errors */
    public array $errors = [];
    public string $exception;
    public string $message = ''; // @deprecated
    public string $path;
    public string $refresh_token;

    public function __construct(object $json)
    {
        foreach ($json as $k => $v) {
            if (!is_null($v))
                $this->$k = $v;
        }

        foreach ($json->errors as $error) {
            $this->errors[] = new LetPayErrorResponseItem($error);
        }
    }
    
    public function getMessage(): string
    {
        return $this->error . " · " . ($this->errors[0]?->description ?? 'Unknown error');
    }

}

/**
 * @link https://docs.epag.io/#error-codes
 */
class LetPayErrorResponseItem
{
    public string $code ;
    public string $description;

    public function __construct(object $error)
    {
        $this->code = $error->code;
        $this->description = $error->description;
    }
}
