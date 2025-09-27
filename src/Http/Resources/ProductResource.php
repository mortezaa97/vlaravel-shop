<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Resources;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mortezaa97\Reviews\Http\Resources\ReviewResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //        $specifications = Specification::where('product_id', $this->id)
        //            ->get()
        //            ->sortByDesc('is_favorite')
        //            ->take(4);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'slug' => $this->slug,
            //            'brand' => new BrandResource($this->whenLoaded('brand')),
            'hover' => $this->hover ? url($this->hover) : null,
            'gallery' => collect($this->gallery)->map(fn ($image) => url($image))->all(),
            'desc' => $this->desc,
            'excerpt' => $this->excerpt,
            'views' => $this->views,
            'colors' => $this->colors,
            'english_name' => $this->english_name,
            'price' => $this->price,
            'rate' => $this->rate,
            //            'variants_availability' => $this->variants_availability,
            'specifications' => SpecificationResource::collection($this->specifications->load('attribute', 'value')),
            'variants' => ProductSimpleResource::collection($this->children),
            'display_name' => $this->display_name,
            'quantity' => $this->when(isset($this->quantity), str($this->quantity)), // موجودی
            'partner_price' => $this->partner_price,
            'user_price' => $this->user_price,
            'sale_price' => $this->sale_price,
            'default_variant' => $this->default_variant,
            'on_sale' => $this->on_sale,
            'offer_price' => $this->offer_price,
            'date_from' => $this->when(isset($this->date_from), $this->date_from),
            'date_to' => $this->when(isset($this->date_to), $this->date_to),
            'sku' => $this->when(isset($this->sku), $this->sku),
            'product_code' => $this->when(isset($this->product_code), $this->product_code),
            'warranty' => $this->warranty,
            'color' => $this->color,
            'attributes' => $this->attribute_values,
            'image' => $this->image ? url($this->image) : null,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'grouped_specifications' => $this->grouped_specifications,
            'breadcrumbs' => $this->breadcrumbs,
            'meta_title' => $this->meta_title,
            'meta_desc' => $this->meta_desc,
            'meta_keywords' => $this->meta_keywords,
            'tags' => TagResource::collection($this->tags),
            'is_liked' => $this->is_liked,
            'is_active' => $this->is_active,
            'options' => $this->options,
            'categories' => CategoryResource::collection($this->categories),
            'reviews' => ReviewResource::collection($this->reviews)->paginate(20),
        ];
    }
}
