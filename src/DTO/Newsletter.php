<?php

declare(strict_types=1);

namespace App\DTO;

class Newsletter
{
    public function __construct(public string $email)
    {
    }
}
