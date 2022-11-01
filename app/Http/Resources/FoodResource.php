<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $this->resource->setNonExpiredStocks();

        return [
            'type' => 'food',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'units' => $this->resource->units,
                'type' => $this->resource->type,
                'stock' => $this->resource->stock,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at
            ]
        ];
    }
}
