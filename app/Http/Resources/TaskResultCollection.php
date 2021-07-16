<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskResultCollection extends ResourceCollection
{
    public const PER_PAGE = 10;
    public const PAGE = 1;

    /**
     * @var int
     */
    private int $page;

    /**
     * @var int
     */
    private int $perPage;

    /**
     * TaskResultCollection constructor.
     *
     * @param Collection $taskResults
     * @param int $page
     * @param int $perPage
     */
    public function __construct(Collection $taskResults, int $page, int $perPage)
    {
        parent::__construct($taskResults);
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(['meta' => "array", 'data' => "\Illuminate\Support\Collection"])]
    public function toArray($request): array
    {
        return [
            'meta' => [
                'page' => $this->page,
                'per-page' => $this->perPage
            ],
            'data' => $this->collection,
        ];
    }
}
