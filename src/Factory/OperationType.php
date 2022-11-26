<?php

namespace PayZero\App\Factory;

use \PayZero\App\Entity\Operation\Type as OperationTypeInterface;

class OperationType
{
    public static function create($type) : OperationTypeInterface
    {
        $class = '\PayZero\App\Entity\Operation\\'.ucfirst($type).'Type';

        if (!class_exists($class) || !($typeClass = new $class) instanceof OperationTypeInterface) {
            throw new \Exception('client type '.$type.' failure');
        }

        return $typeClass;
    }
}