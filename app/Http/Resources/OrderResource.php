<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'type' => 'orders',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'order_status_id' => $this->resource->order_status_id,
                'booking_id' => $this->resource->booking_id,
                'status' => OrderStatusResource::make($this->resource->orderStatus),
                'booking' => BookingResource::make($this->resource->booking),
                'recipes' => OrderRecipeResource::collection($this->resource->recipes),
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at
            ]
        ];
    }
}
