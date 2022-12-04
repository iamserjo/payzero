<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use Exception;
use PayZero\App\Contract\Reader;
use PayZero\App\Entity\Currency;
use PayZero\App\Entity\Operation;
use PayZero\App\Entity\User;
use PayZero\App\Exception\FactoryCreationFailure;
use PayZero\App\Factory\ClientType;
use PayZero\App\Factory\OperationType;

class ReaderToOperation
{
    public function __construct(private readonly Reader $reader)
    {
    }

    /**
     * @throws FactoryCreationFailure
     * @throws Exception
     */
    public function getOperations(): \Generator
    {
        foreach ($this->reader->readFile() as $line) {
            yield new Operation(
                new \DateTime((string) $line[0]),
                new User((int) $line[1]),
                ClientType::create((string) $line[2]),
                OperationType::create((string) $line[3]),
                (string) $line[4],
                new Currency((string) $line[5])
            );
        }
    }
}
