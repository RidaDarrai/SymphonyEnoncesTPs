<?php

declare(strict_types=1);

namespace App\Account\Handler\Strategy;

use App\Account\Repository\UserRepository;
use App\Entity\User;

class DatabaseAccountHandlerStrategy implements AccountHandlerStrategyInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function create(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function update(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function delete(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if ($user !== null) {
            $this->userRepository->save($user);
        }
    }
}
