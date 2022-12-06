<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\File\File;

interface Reader
{
    public function __construct(Validator $validator, File $fileName);

    public function readFile(): \Generator;
}
