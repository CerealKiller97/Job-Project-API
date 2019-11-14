<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RolesServiceInterface;
use App\DTO\CreateRoleDTO;
use App\DTO\RoleDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Role;
use Hashids\HashidsInterface;

class RolesService implements RolesServiceInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashids;

    /**
     * RolesService constructor.
     * @param  HashidsInterface  $hashids
     */
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
     * @throws EntityNotFoundException
     */
    public function getRole(string $id): object
    {
        $role = Role::find($this->hashids->decode($id)[0] ?? null);

        if ($role === null) {
            throw new EntityNotFoundException("Role");
        }

        $roleDto = new RoleDTO();

        return $this->mapDTO($role, $roleDto);
    }

    /**
     * @param  CreateRoleDTO  $roleDTO
     */
    public function createRole(CreateRoleDTO $roleDTO): void
    {
        Role::create([
           'name' => $roleDTO->name
        ]);
    }

    /**
     * @param  string  $id
     * @param  CreateRoleDTO  $roleDTO
     * @throws EntityNotFoundException
     */
    public function updateRole(string $id, CreateRoleDTO $roleDTO): void
    {
        $role = Role::find($this->hashids->decode($id)[0] ?? null);

        if ($role === null) {
            throw new EntityNotFoundException("Role");
        }

        $role->name = $roleDTO->name;

        $role->save();
    }

    /**
     * @param  string  $id
     * @throws EntityNotFoundException
     */
    public function deleteRole(string $id): void
    {
        $role = Role::find($this->hashids->decode($id)[0] ?? null);

        if ($role === null) {
            throw new EntityNotFoundException("Role");
        }

        $role->delete();
    }

    private function mapDTO(object $roleDB, RoleDTO $roleDto): RoleDTO
    {
        $roleDto->id = $this->hashids->encode($roleDB->id);
        $roleDto->name = $roleDB->name;

        return $roleDto;
    }
}
