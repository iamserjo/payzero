<?php

declare(strict_types=1);

namespace PayZero\App\Console;

use PayZero\App\Exception\ConsoleArgumentMissingException;
use PayZero\App\Validator\ArgumentReader as ArgumentReaderValidator;

class ArgumentReader
{
    /**
     * @throws ConsoleArgumentMissingException
     */
    public function __construct(private readonly array $arguments)
    {
        $this->validateArguments();
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getFirstArgument(): string
    {
        return $this->arguments[1];
    }

    /**
     * @throws ConsoleArgumentMissingException
     */
    private function validateArguments(): void
    {
        (new ArgumentReaderValidator())->validate($this->arguments);
    }
}
