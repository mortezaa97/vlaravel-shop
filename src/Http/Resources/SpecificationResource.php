<?php

namespace Mortezaa97\Shop\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attribute_name' => $this->attribute?->name,
            'attribute_media' => $this->attribute?->image ? url($this->attribute?->image) : null,
            'value_title' => $this->value?->title,
        ];
    }
}
