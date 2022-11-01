<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'type' => 'bookings',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'email' => $this->resource->email,
                'phone' => $this->resource->phone,
                'date' => $this->resource->date,
                'people' => $this->resource->people,
                'table' => $this->resource->table,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at
            ]
        ];
    }
}
