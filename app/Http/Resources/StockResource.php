<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'stocks',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'quantity' => $this->resource->quantity,
                'expiration_date' => $this->resource->expiration_date,
                'expired' => $this->resource->expired,
                'food_id' => $this->resource->food_id,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at
            ]
        ];
    }
}
