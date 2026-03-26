<?php

declare(strict_types=1);

namespace App\Account\Handler;

use App\Account\Factory\DefaultAccountFactory;
use App\Account\Handler\Strategy\AccountHandlerStrategyInterface;
use App\Account\Handler\Strategy\DatabaseAccountHandlerStrategy;
use App\DTO\RegistrationRequest;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class AccountHandler implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private DefaultAccountFactory $accountFactory,
        private AccountHandlerStrategyInterface $accountHandlerStrategy
    ) {
    }

    public function register(RegistrationRequest $request): bool
    {
        $user = $this->accountFactory->createFromRequest($request);

        try {
            $this->accountHandlerStrategy->create($user);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function loadUserByIdentifier(string $identifier): \Symfony\Component\Security\Core\User\UserInterface
    {
        throw new \LogicException('Method not implemented yet.');
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user): \Symfony\Component\Security\Core\User\UserInterface
    {
        throw new \LogicException('Method not implemented yet.');
    }

    public function supportsClass(string $class): bool
    {
        return $class === \App\Entity\User::class;
    }

    public function upgradePassword(\Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $user->setPassword($newHashedPassword);
        $this->accountHandlerStrategy->update($user);
    }
}
