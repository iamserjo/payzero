<?php

declare(strict_types=1);

namespace PayZero\App\Validator;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\ConsoleArgumentMissingException;

class ArgumentReader implements Validator
{
    /**
     * @throws ConsoleArgumentMissingException
     */
    public function validate($data): void
    {
        if (empty($data[1])) {
            throw new ConsoleArgumentMissingException('First argument is required');
        }
    }
}
