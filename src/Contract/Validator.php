<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

interface Validator
{
    public function validate($data): void;
}
