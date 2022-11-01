<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
            'type' => 'recipes',
            'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'price' => $this->resource->price,
                'type' => $this->resource->type,
                'food_type' => $this->resource->food_type,
                'available' => $this->resource->available,
                'food' => FoodRecipeResource::collection($this->resource->food),
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at
            ]
        ];
    }
}
