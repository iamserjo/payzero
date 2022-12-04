<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\ClientType as ClientTypeInterface;
use PayZero\App\Exception\FactoryCreationFailure;

class ClientType
{
    /**
     * @throws FactoryCreationFailure
     */
    public static function create($type): ClientTypeInterface
    {
        // I hate this approach :D
        $class = '\PayZero\App\Entity\Client\\'.ucfirst($type).'Type';

        if (!class_exists($class)) {
            throw new FactoryCreationFailure('client type '.$type.' failure');
        }
        /**
         * @var $class ClientTypeInterface
         */
        $classType = new $class();
        $classType->setTypeName($type);

        return $classType;
    }
}
