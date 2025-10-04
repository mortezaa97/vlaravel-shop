<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Resources;

use App\Http\Resources\CategorySimpleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            //            'brand' => new BrandResource($this->whenLoaded('brand')),
            'image' => $this->image ? url($this->image) : null,
            'hover' => $this->hover ? url($this->hover) : null,
            //            'gallery' => collect($this->gallery)->map(fn ($image) => url($image))->all(),
            //            'desc' => $this->desc,
            //            'excerpt' => $this->excerpt,
            //            'views' => $this->views,
            //            'colors' => $this->colors,
            'english_name' => $this->english_name,
            //            'price' => $this->price,
            'rate' => $this->rate,
            //            'variants_availability' => $this->variants_availability,
            //            'display_name' => $this->display_name,
            //            'quantity' => $this->when(isset($this->quantity), str($this->quantity)), // موجودی
            //            'partner_price' => $this->partner_price,
            //            'user_price' => $this->user_price,
                        'sale_price' => $this->sale_price,
            //            'on_sale' => $this->on_sale,
            //            'offer_price' => $this->offer_price,
            //            'date_from' => $this->when(isset($this->date_from), $this->date_from),
            //            'date_to' => $this->when(isset($this->date_to), $this->date_to),
            //            'sku' => $this->when(isset($this->sku), $this->sku),
            //            'warranty' => $this->warranty,
            //            'color' => $this->color,
            //            'attributes' => $this->attribute_values,
            //            'status' => $this->status,
            'is_liked' => $this->is_liked,
            //            'is_active' => $this->is_active,
            //            'options' => $this->options,
            'default_variant' => new ProductVariantResource($this->default_variant),
            'categories' => CategorySimpleResource::collection($this->whenLoaded('categories')),
            //            'grouped_specifications' => $this->grouped_specifications,
            //            'specifications' => SpecificationResource::collection($this->specifications->load('attribute', 'value')),
        ];
    }
}
