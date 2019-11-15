<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Hashids\HashidsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Job extends JsonResource
{
    /**
     * @var HashidsInterface
     */
    private $hashids;

    /**
     * Job constructor.
     * @param $resource
     * @param  HashidsInterface  $hashids
     */
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
    public function toArray($request)
    {
        return [
            'id' => $this->hashids->encode($this->resource->id),
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'state' => $this->resource->state,
            'valid_until' => Carbon::parse($this->resource->valid_until)->format('d.m.Y')
        ];
    }
}
