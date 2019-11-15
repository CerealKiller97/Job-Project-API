<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Hashids\HashidsInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Jobs extends ResourceCollection
{
    /**
     * @var HashidsInterface
     */
    private $hashids;

    /**
     * Jobs constructor.
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
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($job) {
                return [
                    'id' => $this->hashids->encode($job->id),
                    'title' => $job->title,
                    'description' => $job->description,
                    'state' => $job->state,
                    'valid_until' => Carbon::parse($job->valid_until)->format('d.m.Y')
                ];
            })
        ];
    }
}
