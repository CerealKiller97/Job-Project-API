<?php

namespace App\Http\Resources;

use Hashids\HashidsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Roles extends ResourceCollection
{

    /**
     * @var HashidsInterface
     */
    private $hashids;

    public function __construct($resource, HashidsInterface $hashids)
    {
        parent::__construct($resource);
        $this->hashids = $hashids;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($role) {
                return [
                    'id' => $this->hashids->encode($role->id),
                    'name' => $role->name,
                ];
            }),
        ];
    }
}
