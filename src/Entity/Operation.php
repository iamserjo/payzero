<?php

namespace PayZero\App\Entity;

use PayZero\App\Entity\Client\Type as ClientType;
use PayZero\App\Entity\Operation\Type as OperationType;

class Operation
{
    private \DateTime $date;

    public function __construct(\DateTime  $date,
                                User       $user,
                                ClientType $clientType,
                                OperationType $operationType,
                                float      $amount,
                                Currency   $currency
    ) {
    }
}