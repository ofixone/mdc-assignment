<?php

namespace App\Model\Entity\Store;

final class Supermarket extends AbstractStore
{
    public const TYPE = 'supermarket';

    public function getType(): string
    {
        return self::TYPE;
    }
}
