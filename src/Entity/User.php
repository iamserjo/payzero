<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class User
{
    public function __construct(private readonly int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
