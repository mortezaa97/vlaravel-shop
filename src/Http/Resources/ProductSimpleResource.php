<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Resources;

use App\Http\Resources\CategoryResource;
use Mortezaa97\Shop\Http\Resources\SpecificationResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mortezaa97\Reviews\Http\Resources\ReviewResource;

class ProductSimpleResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'slug' => $this->slug,
            'image' => $this->image ? url($this->image) : null,
            'hover' => $this->hover ? url($this->hover) : null,
            'gallery' => collect($this->gallery)->map(fn ($image) => url($image))->all(),
            'price' => $this->price,
            'quantity' => $this->when(isset($this->quantity), str($this->quantity)), // موجودی
            'partner_price' => $this->partner_price,
            'user_price' => $this->user_price,
            'sale_price' => $this->sale_price,
            'on_sale' => $this->on_sale,
            'offer_price' => $this->offer_price,
            'date_from' => $this->when(isset($this->date_from), $this->date_from),
            'date_to' => $this->when(isset($this->date_to), $this->date_to),
            'sku' => $this->when(isset($this->sku), $this->sku),
            'product_code' => $this->when(isset($this->product_code), $this->product_code),
            'warranty' => $this->warranty,
            'color' => $this->color,
            'attributes' => $this->attribute_values,
            'status' => $this->status,
        ];
    }
}
