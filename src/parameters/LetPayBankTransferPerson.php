<?php /** @noinspection PhpUnused */

namespace LetPay\parameters;

class LetPayBankTransferPerson
{
    public string $type; // Only used and required in Colombia. COMPANY or NATURAL_PERSON
    public string $email;
    public ?string $full_name;
    /**
     * @var string Unique identifier for this person in country tax system
     */
    public string $tax_id;
    /**
     * @var string Type of identifier for this person in its country tax system
     * (e.g. in Chile: RUT). Valid options: RUT, CC, PP
     * (e.g. in Colombia: NIT). Valid options: NIT, CC, CE, TI, PP
     */
    public string $tax_id_type;

    public function __construct(array $params)
    {
        foreach ($params as $k => $v)
            $this->$k = $v;
    }

}
