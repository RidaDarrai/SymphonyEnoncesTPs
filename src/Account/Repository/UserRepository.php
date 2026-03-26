<?php

declare(strict_types=1);

namespace App\Account\Repository;

use App\Entity\User;

class UserRepository
{
    private array $users = [];
    private int $nextId = 1;
    private string $storageFile;

    public function __construct()
    {
        $this->storageFile = dirname(__DIR__, 2) . '/var/data/users.json';
        $this->load();
    }

    private function load(): void
    {
        if (file_exists($this->storageFile)) {
            $data = json_decode(file_get_contents($this->storageFile), true);
            $this->users = [];
            foreach ($data['users'] ?? [] as $item) {
                $user = new User();
                $user->setId($item['id']);
                $user->setFullName($item['fullName']);
                $user->setEmail($item['email']);
                $user->setPassword($item['password']);
                $user->setPhone($item['phone']);
                $user->setRoles($item['roles'] ?? ['ROLE_USER']);
                $this->users[$item['email']] = $user;
            }
            $this->nextId = $data['nextId'] ?? 1;
        }
    }

    private function persist(): void
    {
        $dir = dirname($this->storageFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $data = [
            'users' => [],
            'nextId' => $this->nextId,
        ];
        foreach ($this->users as $user) {
            $data['users'][] = [
                'id' => $user->getId(),
                'fullName' => $user->getFullName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'phone' => $user->getPhone(),
                'roles' => $user->getRoles(),
            ];
        }
        file_put_contents($this->storageFile, json_encode($data));
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            $user->setId($this->nextId++);
            $this->users[$user->getEmail()] = $user;
        }
        $this->persist();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->users[$email] ?? null;
    }

    public function find(int $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }
}
