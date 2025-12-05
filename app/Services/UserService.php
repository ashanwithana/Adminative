<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\DTOs\UserDTO;
use App\Models\User;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function createUser(UserDTO $dto): User
    {
        $user = $this->userRepository->create($dto->toArray());

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('User created');

        return $user;
    }

    public function updateUser(User $user, UserDTO $dto): User
    {
        $updatedUser = $this->userRepository->update($user, $dto->toArray());

        activity()
            ->performedOn($updatedUser)
            ->causedBy(auth()->user())
            ->log('User updated');

        return $updatedUser;
    }

    public function deleteUser(User $user): bool
    {
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('User deleted');

        return $this->userRepository->delete($user);
    }

    public function assignRole(User $user, string|array $roles): void
    {
        $this->userRepository->assignRole($user, $roles);

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['roles' => $roles])
            ->log('Role assigned');
    }
}
