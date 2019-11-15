<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateRole;
use App\Exceptions\EntityNotFoundException;
use App\Http\Resources\Role;
use App\Http\Resources\Roles;

interface RolesServiceInterface
{
    /**
     * @return Roles
     */
    public function getRoles(): Roles;

    /**
     * @param  string  $id
     * @return Role
     */
    public function getRole(string $id): Role;

    /**
     * @param  CreateRole  $roleDTO
     */
    public function createRole(CreateRole $roleDTO): void;

    /**
     * @param  string  $id
     * @param  CreateRole  $roleDTO
     * @return bool
     */
    public function updateRole(string $id, CreateRole $roleDTO): bool;

    /**
     * @param  string  $id
     * @throws EntityNotFoundException
     * @return bool
     */
    public function deleteRole(string $id): bool;

    /**
     * @return array
     */
    public function getModeratorEmails(): array;
}
