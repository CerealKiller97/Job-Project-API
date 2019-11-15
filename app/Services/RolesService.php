<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RolesServiceInterface;
use App\DTO\CreateRole;
use App\Exceptions\EntityNotFoundException;
use App\Http\Resources\Roles;
use App\Models\Role;
use App\Models\User;
use Hashids\HashidsInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
     * @return Roles
     */
    public function getRoles(): Roles
    {
        /**
         * @var Role[] $roles
         */
        $roles = Role::all(['id', 'name']);

        return new Roles($roles, $this->hashids);
    }

    /**
     * @param  string  $id
     * @return \App\Http\Resources\Role
     */
    public function getRole(string $id): \App\Http\Resources\Role
    {
        /**
         * @var Role $role
         */
        $role = Role::findOrFail($this->hashids->decode($id)[0] ?? null);

        return new \App\Http\Resources\Role($role, $this->hashids);
    }

    /**
     * @param  CreateRole  $roleDTO
     */
    public function createRole(CreateRole $roleDTO): void
    {
        Role::create([
           'name' => $roleDTO->name
        ]);
    }

    /**
     * @param  string  $id
     * @param  CreateRole  $roleDTO
     * @return bool
     */
    public function updateRole(string $id, CreateRole $roleDTO): bool
    {
        DB::beginTransaction();

        $updated = Role::query()->where('id', '=', $this->hashids->decode($id)[0] ?? null)
                            ->update([
                                'name' => $roleDTO->name
                            ]) > 0;

        if ($updated) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }

    /**
     * @param  string  $id
     * @return bool
     * @throws EntityNotFoundException
     */
    public function deleteRole(string $id): bool
    {
        DB::beginTransaction();
        $deleted = Role::destroy($this->hashids->decode($id)[0] ?? null) > 0;

        if ($deleted) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        throw new EntityNotFoundException("Role");
    }

    public function getModeratorEmails(): array
    {
        return User::query()->where('role_id', '=', 2)->pluck('email')->toArray();
    }
}
