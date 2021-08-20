<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /**
     * Pagination metadata.
     *
     * @var array
     */
    protected $meta;

    /**
     * Pagination links.
     *
     * @var array
     */
    protected $links;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->links = [
            'first' => $this->url(1),
            'last' => $this->url($this->lastPage()),
            'prev' => $this->previousPageUrl(),
            'next' => $this->nextPageUrl()
        ];

        $this->meta = [
            'count' => $this->count(),
            'current_page' => $this->currentPage(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total()
        ];

        $data = [
            'collection' => $this->collection,
            'links' => $this->links,
            'meta' => $this->meta
        ];
        return $data;
    }
}
