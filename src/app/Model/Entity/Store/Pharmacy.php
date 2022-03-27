<?php

namespace App\Model\Entity\Store;

final class Pharmacy extends AbstractStore
{
    public const TYPE = 'pharmacy';

    public function getType(): string
    {
        return self::TYPE;
    }
}
