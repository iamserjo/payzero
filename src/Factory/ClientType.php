<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\ClientType as ClientTypeInterface;
use PayZero\App\Entity\Client\BusinessType;
use PayZero\App\Entity\Client\PrivateType;
use PayZero\App\Exception\FactoryCreationFailure;

class ClientType
{
    /**
     * @throws FactoryCreationFailure
     */
    public static function create($typeName): ClientTypeInterface
    {
        return match ($typeName) {
            'business' => new BusinessType($typeName),
            'private' => new PrivateType($typeName),
            'default' => throw new FactoryCreationFailure('client type '.$typeName.' creation failure')
        };
    }
}
