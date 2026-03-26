<?php

declare(strict_types=1);

namespace App\DTO;

class Credentials
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }
}
