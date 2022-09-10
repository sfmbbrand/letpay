<?php /** @noinspection PhpUnused */

namespace LetPay\response;

class LetPayTokenResponse
{

    public LetPayUserResponse $user;
    public string $version;
    public string $token;

    public function __construct(object $json)
    {
        $this->user = new LetPayUserResponse($json->user);
        $this->version = $json->version;
        $this->token = $json->token;
    }

}

class LetPayUserResponse
{
    public string $role;
    public bool $enable;
    public string $name;
    public string $id;
    public string $merchant_id;
    public bool $open;
    public string $username;

    public function __construct(object $json)
    {
        foreach ($json as $k => $v)
            $this->$k = $v;
    }
}
