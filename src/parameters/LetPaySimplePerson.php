<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPaySimplePerson
{
    public ?string $full_name;
    public ?string $email;
    public ?string $birthdate;
    /**
     * Unique identifier for this person in country tax system (e.g. in Brazil: CPF).
     * @var string|null $tax_id
     */
    public ?string $tax_id;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }

}
