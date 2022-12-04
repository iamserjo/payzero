<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\OperationType as OperationTypeInterface;
use PayZero\App\Exception\FactoryCreationFailure;

class OperationType
{
    /**
     * @throws FactoryCreationFailure
     */
    public static function create($type): OperationTypeInterface
    {
        // I hate this approach :D
        $class = '\PayZero\App\Entity\Operation\\'.ucfirst($type).'Type';

        if (!class_exists($class)) {
            throw new FactoryCreationFailure('client type '.$type.' failure');
        }
        /*
         * @var $typeClass OperationTypeInterface
         */
        $typeClass = new $class();
        $typeClass->setTypeName($type);

        return $typeClass;
    }
}
