<?php

namespace App\Model\Entity\Store;

final class CornerShop extends AbstractStore
{
    public const TYPE = 'corner shop';

    public function getType(): string
    {
        return self::TYPE;
    }
}
