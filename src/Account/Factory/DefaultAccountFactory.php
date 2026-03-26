<?php

declare(strict_types=1);

namespace App\Account\Factory;

use App\DTO\RegistrationRequest;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DefaultAccountFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function createFromRequest(RegistrationRequest $request): User
    {
        $user = new User();
        $user->setFullName($request->fullName);
        $user->setEmail($request->email);
        $user->setPhone($request->phone);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $request->password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
