<?php

declare(strict_types=1);

namespace App\DTO;

use App\Validator\Constraints\PasswordField;
use App\Validator\Constraints\RequiredField;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationRequest
{
    #[Assert\Email(message: 'Cette adresse email est invalide.')]
    #[RequiredField]
    protected ?string $email = null;

    #[RequiredField]
    #[PasswordField]
    private ?string $password = null;

    #[RequiredField]
    private ?string $fullName = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}
