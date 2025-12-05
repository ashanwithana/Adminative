<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findByPhone(string $phone): ?User;

    public function findByEmailOrPhone(string $identifier): ?User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function delete(User $user): bool;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function updateLastLogin(User $user): void;

    public function assignRole(User $user, string|array $roles): void;

    public function syncPermissions(User $user, array $permissions): void;
}
