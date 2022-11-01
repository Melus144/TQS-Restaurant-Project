<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRecipeResource extends JsonResource
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
            'order_id' => $this->resource->pivot->order_id,
            'recipe_id' => $this->resource->pivot->recipe_id,
            'recipe_name' => $this->resource->name,
            'quantity' => $this->resource->pivot->quantity,
            'price' => $this->resource->pivot->price,
            'created_at' => $this->resource->pivot->created_at->jsonSerialize(),
            'updated_at' => $this->resource->pivot->updated_at->jsonSerialize()
        ];
    }
}
