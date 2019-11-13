<?php

declare(strict_types=1);

namespace App\DTO;

class PagedResponse
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var int
     */
    public $page;
    /**
     * @var int
     */
    public $pagesCount;
    /**
     * @var int
     */
    public $total;

    /**
     * PagedResponse constructor.
     * @param  array  $data
     * @param  int  $total
     * @param  int  $page
     * @param  int  $pagesCount
     */
    public function __construct(array $data = [], int $total,int $page, int $pagesCount)
    {
        $this->data = $data;
        $this->page = $page;
        $this->pagesCount = $pagesCount;
        $this->total = $total;
    }
}
