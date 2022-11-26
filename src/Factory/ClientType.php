<?php

namespace PayZero\App\Factory;

use \PayZero\App\Entity\Client\Type as ClientTypeInterface;

class ClientType
{
    public static function create($type) : ClientTypeInterface
    {
        $class = '\PayZero\App\Entity\Client\\'.ucfirst($type).'Type';

        if (!class_exists($class) || !($typeClass = new $class) instanceof ClientTypeInterface) {
            throw new \Exception('client type '.$type.' failure');
        }

        return $typeClass;
    }
}