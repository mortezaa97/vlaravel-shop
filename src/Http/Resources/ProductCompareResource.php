<?php

namespace Mortezaa97\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCompareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->attribute?->id ?? '',
            'product_title' => $this->product?->name ?? '',
            'product_slug' => $this->product?->slug ?? '',
            'desc' => $this->desc,
            'value_title' => $this->value?->title ?? '',
            'value_desc' => $this->value?->desc ?? '',
            'attribute_name' => $this->attribute?->name ?? '',
        ];
    }
}
