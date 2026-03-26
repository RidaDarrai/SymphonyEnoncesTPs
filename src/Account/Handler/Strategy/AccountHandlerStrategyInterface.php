<?php

declare(strict_types=1);

namespace App\Account\Handler\Strategy;

use App\Entity\User;

interface AccountHandlerStrategyInterface
{
    public function create(User $user): void;
    public function update(User $user): void;
    public function delete(int $userId): void;
}
