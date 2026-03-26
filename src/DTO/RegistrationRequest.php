<?php

declare(strict_types=1);

namespace App\DTO;

class RegistrationRequest
{
    public function __construct(
        public ?string $fullName = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $phone = null,
    ) {
    }
}
