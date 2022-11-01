<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiDataResource extends JsonResource
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
            'date' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->resource->booking->date)->toDateString(),
            'food_types' => $this->resource->getFoodTypes(),
            'festive' => $this->resource->getFestive()
        ];
    }
}
