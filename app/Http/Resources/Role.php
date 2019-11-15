<?php

namespace App\Http\Resources;

use Hashids\HashidsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{

    /**
     * @var HashidsInterface
     */
    private $hashids;

    public function __construct($resource, HashidsInterface $hashids)
    {
        parent::__construct($resource);

        $this->resource = $resource;
        $this->hashids = $hashids;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->hashids->encode($this->resource->id),
            'name' => $this->resource->name
        ];
    }
}
