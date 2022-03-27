<?php

namespace App\Model\Entity\Store\Assortment;

use App\Model\Exceptions\UnpredictableProductType;

class Product
{
    public const TYPE_FOOD           = 'food';
    public const TYPE_DRINK          = 'drink';
    public const TYPE_MEDICINE       = 'medicine';
    public const TYPE_CIGARETTE      = 'cigarettes';
    public const TYPE_TOY            = 'toy';
    public const TYPE_PARKING_TICKET = 'parking ticket';
    private static array $suitableTypes
        = [
            self::TYPE_FOOD,
            self::TYPE_DRINK,
            self::TYPE_MEDICINE,
            self::TYPE_CIGARETTE,
            self::TYPE_TOY,
            self::TYPE_PARKING_TICKET
        ];
    private string $type;
    private string $name;

    public function __construct(string $type, string $name)
    {
        if (!in_array($type, self::$suitableTypes)) {
            throw new UnpredictableProductType(self::$suitableTypes);
        }
        $this->type = $type;
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
