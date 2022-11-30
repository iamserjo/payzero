<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\OperationType as OperationTypeInterface;

class OperationType
{
    public static function create($type): OperationTypeInterface
    {
        $class = '\PayZero\App\Entity\Operation\\'.ucfirst($type).'Type';

        if (!class_exists($class) || !($typeClass = new $class()) instanceof OperationTypeInterface) {
            throw new \Exception('client type '.$type.' failure');
        }
        /*
         * @var $typeClass OperationTypeInterface
         */
        $typeClass->setTypeName($type);

        return $typeClass;
    }
}
