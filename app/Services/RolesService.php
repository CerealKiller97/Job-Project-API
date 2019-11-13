<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RolesServiceInterface;
use App\DTO\CreateRoleDTO;
use App\DTO\RoleDTO;
use App\Models\Role;
use Hashids\HashidsInterface;

class RolesService implements RolesServiceInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashids;

    public function __construct(HashidsInterface $hashids)
    {
        $this->hashids = $hashids;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = Role::query()->select(['id', 'name'])->get();

        $mapped = [];
        foreach ($roles as $role) {
            $roleDto = new RoleDTO();

            $mapped[] = $this->mapDTO($role, $roleDto);
        }

        return $mapped;
    }

    /**
     * @param  string  $id
     * @return object
     */
    public function getRole(string $id): object
    {
        // TODO: Implement getRole() method.
    }

    /**
     * @param  CreateRoleDTO  $roleDTO
     */
    public function createRole(CreateRoleDTO $roleDTO): void
    {
        // TODO: Implement createRole() method.
    }

    /**
     * @param  string  $id
     * @param  CreateRoleDTO  $roleDTO
     */
    public function updateRole(string $id, CreateRoleDTO $roleDTO): void
    {
        // TODO: Implement updateRole() method.
    }

    /**
     * @param  string  $id
     */
    public function deleteRole(string $id): void
    {
        // TODO: Implement deleteRole() method.
    }

    private function mapDTO(object $roleDB, RoleDTO $roleDto): RoleDTO
    {
        $roleDto->id = $this->hashids->encode($roleDB->id);
        $roleDto->name = $roleDB->name;

        return $roleDto;
    }
}
