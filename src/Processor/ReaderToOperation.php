<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use PayZero\App\File\Reader;

class ReaderToOperation
{
    public function __construct(private readonly Reader $reader)
    {
    }

    public function process()
    {
        foreach ($this->reader->getLines() as $line) {
        }

//        $operations[] = new Operation(
//            new \DateTime((string) $data[0]),
//            new User((int) $data[1]),
//            ClientType::create((string) $data[2]),
//            OperationType::create((string) $data[3]),
//            (float) $data[4],
//            new Currency((string) $data[5])
//        );
    }
}
