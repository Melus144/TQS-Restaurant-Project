<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StockCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => StockResource::collection($this->collection)
        ];
    }
}
