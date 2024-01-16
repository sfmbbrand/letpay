<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePerson
{
    public string $full_name;
    public string $email;
    public string $birthdate;
    public ?string $tax_id;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }

}
