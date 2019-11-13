<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateRoleDTO;

interface RolesServiceInterface
{
    /**
     * @return array
     */
    public function getRoles(): array;

    /**
     * @param  string  $id
     * @return object
     */
    public function getRole(string $id): object;

    /**
     * @param  CreateRoleDTO  $roleDTO
     */
    public function createRole(CreateRoleDTO $roleDTO): void;

    /**
     * @param  string  $id
     * @param  CreateRoleDTO  $roleDTO
     */
    public function updateRole(string $id, CreateRoleDTO $roleDTO): void;

    /**
     * @param  string  $id
     */
    public function deleteRole(string $id): void;
}
