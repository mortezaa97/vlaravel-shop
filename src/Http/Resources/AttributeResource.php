<?php

namespace Mortezaa97\Shop\Http\Resources;

use Mortezaa97\Shop\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => url($this->image),
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => new Attribute($this->parent),
            'order' => $this->order,
            'values' => $this->whenLoaded('values'),
        ];
    }
}
