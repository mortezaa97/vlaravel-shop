<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Resources;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mortezaa97\Reviews\Http\Resources\ReviewResource;

class ProductVariantResource extends JsonResource
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
            'hover' => $this->hover ? url($this->hover) : null,
            'colors' => $this->colors,
            'english_name' => $this->english_name,
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
            'image' => $this->image ? url($this->image) : null,
            'status' => $this->status,
        ];
    }
}
