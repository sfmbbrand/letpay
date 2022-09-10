<?php

namespace LetPay\response;

class LetPayContractResponse
{

    public string $refresh_token;
    public LetPayContract $contract;

    public function __construct(object $json)
    {
        $this->refresh_token = $json->refresh_token;
        $this->contract = new LetPayContract($json->contract);
    }

}

class LetPayContract
{
    public string $createdAt; // "YYYY-MM-DD-HH:mm:SS"
    public string $id;

    public function __construct(object $json)
    {
        $this->createdAt = $json->createdAt;
        $this->id = $json->id;
    }
}
