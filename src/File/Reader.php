<?php

declare(strict_types=1);

namespace PayZero\App\File;

interface Reader
{
    public function __construct(File $fileName);

    public function getLines(): array;
}
