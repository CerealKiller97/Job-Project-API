<?php

namespace App\Rules;

use App\Models\Role;
use Hashids\HashidsInterface;
use Illuminate\Contracts\Validation\Rule;

class HashedRoleRule implements Rule
{

    /**
     * @var HashidsInterface
     */
    private $hashids;

    /**
     * Create a new rule instance.
     *
     * @param  HashidsInterface  $hashids
     */
    public function __construct(HashidsInterface $hashids)
    {
        $this->hashids = $hashids;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $hashedRole = $this->hashids->decode($value)[0] ?? null;

        if ($hashedRole === null) {
            return false;
        }

        $roleIdFromDB = Role::find($hashedRole)->id;
        // next, you compare this with the received value.
        return $hashedRole === $roleIdFromDB;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid role.';
    }
}
