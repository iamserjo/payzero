<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class User
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}