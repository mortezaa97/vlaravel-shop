<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Models;

use App\Enums\Status;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeProduct;
use Mortezaa97\Shop\Models\AttributeValue;
use App\Models\Category;
use App\Models\Faq;
use Mortezaa97\Shop\Models\Specification;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mortezaa97\Reviews\Models\Review;
use Mortezaa97\Wishlist\Models\Wishlist;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'gallery' => 'json',
        'meta_keywords' => 'array',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'options',
        'prices',
        'is_active',
        'on_sale',
        'rate',
        'price',
        'min_price',
        'offer_price',
        'is_liked',
        'default_variant',
        'breadcrumbs',
    ];

    protected $with = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });

        static::creating(function ($item) {
            if (! isset($item->slug)) {
                $item->slug = Str::slug($item->name);
            }
            $item->sku = mt_rand(100, 999);
            if (! $item->code) {
                $code = random_int(100000, 999999);
                while (self::withTrashed()->where('code', $code)->exists()) {
                    $code = random_int(100000, 999999);
                }
                $item->code = $code;
            }

            $item->updated_by = auth()->id();
            $item->updated_at = now();

            if (! $item->status) {
                $item->status = Status::DRAFT;
            }
        });

        static::updating(function ($item) {
            $item->updated_by = auth()->id();
        });
    }

    /*
     * Accessors
     */
    public function getPricesAttribute(): array
    {
        return $this->children()->orderBy('price')->pluck('price')->toArray();
    }

    public function getIsActiveAttribute()
    {
        return $this->status === Status::PUBLISHED && $this->children()->active()->exists();
    }

    public function getVariantsAvailabilityAttribute()
    {
        return $this->children()->sum('quantity');
    }

    public function getOptionsAttribute()
    {
        return $this->attributeProducts()
            ->with(['attribute', 'value']) // Eager-load attribute and value
            ->whereHas('attribute') // Ensure valid attributes
            ->whereHas('value') // Ensure valid attribute values
            ->withoutGlobalScopes()
            ->get()
            ->groupBy('attribute.name') // Group by attribute name
            ->map(function ($group) {
                if (! $group || $group->isEmpty()) {
                    return null;
                }

                $firstItem = $group->first();

                if (! $firstItem->attribute) {
                    return null;
                }

                return [
                    'slug' => $firstItem->attribute->slug,
                    'name' => $firstItem->attribute->name,
                    'values' => $group->pluck('value.title')->values()->toArray(),
                ];
            })
            ->filter() // Remove null entries
            ->values() // Reset array keys
            ->toArray();
    }

    public function getGroupedSpecificationsAttribute()
    {
        $specifications = $this->specifications()
            ->with(['attribute.parent', 'value'])
            ->get()
            ->sortBy('attribute.parent.order')
            ->groupBy('attribute.parent.name')
            ->map(function ($group) {
                return $group->map(function ($spec) {
                    return [
                        'desc' => $spec->desc,
                        'attribute' => [
                            'id' => $spec->attribute->id,
                            'name' => $spec->attribute->name,
                            'slug' => $spec->attribute->slug,
                        ],
                        'value' => $spec->value ? [
                            'id' => $spec->value->id,
                            'title' => $spec->value->title,
                            'hex' => $spec->value->hex,
                            'desc' => $spec->value->desc,
                        ] : null,
                    ];
                });
            });

        return $specifications;
    }

    public function getBreadcrumbsAttribute()
    {
        $breadcrumbs = [];
        $category = $this->categories()->first();

        while ($category) {
            $breadcrumbs[] = [
                'title' => $category->title,
                'url' => '/' . $category->slug,
            ];
            $category = $category->parent;
        }

        return array_reverse($breadcrumbs);
    }

    public function getRateAttribute()
    {
        $averageRate = $this->reviews()->avg('rate') ?? 4.5;

        return number_format($averageRate, 1);
    }

    public function getIsLikedAttribute()
    {
        $user = Auth::guard('api')->user();
        if (! $user) {
            return false;
        }

        return (bool) Wishlist::where(['user_id' => $user->id, 'model_id' => $this->id,'model_type'=>self::class])->count();
    }

    public function getMinPriceAttribute()
    {
        return min(
            $this->available()->min('price'),
            $this->children()->available()->min('price')
        );
    }

    public function getOnSaleAttribute()
    {
        return $this->children()
            ->available()
            ->whereNotNull('sale_price')
            ->where('date_from', '<=', Carbon::today()->toDateString())
            ->where('date_to', '>=', Carbon::today()->toDateString())
            ->exists();
    }

    public function getDefaultVariantAttribute()
    {
        return $this->children()
            ->available()
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNotNull('sale_price')
                        ->where('date_from', '<=', Carbon::today()->toDateString())
                        ->where('date_to', '>=', Carbon::today()->toDateString())
                        ->orderBy('sale_price', 'asc');
                })->orWhere(function ($q) {
                    $q->whereNull('sale_price')
                        ->orderBy('price', 'desc');
                });
            })
            ->first();
    }

    public function getValidVariationsAttribute()
    {
        $items = $this->hasQuantityVariants($this->children()->orderBy('price'));
        if (isset($items)) {
            return $items;
        }

        return [];
    }

    public function getPriceAttribute()
    {
        $item = $this->children()->whereNotNull('sale_price')
            ->where('date_from', '<=', Carbon::today()->toDateString())
            ->where('date_to', '>=', Carbon::today()->toDateString())->limit(1)->value('price');
        if ($item) {
            return $item;
        }

        return $this->children()->available()->min('price');
    }

    public function getOfferPriceAttribute()
    {
        $item = $this->children()->available()
            ->whereNotNull('sale_price')
            ->where('date_from', '<=', Carbon::today()->toDateString())
            ->where('date_to', '>=', Carbon::today()->toDateString())->value('sale_price');
        if ($item) {
            return $item;
        }

        return null;
    }

    public function getValuesAttribute()
    {
        return $this->attributes()
            ->with('value')
            ->get()
            ->filter(function ($variant) {
                return $variant->variant->quantity > 0;
            })->pluck('value')->flatten()->unique()->values();
    }

    /*
    * Relations
    */
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'model_has_tags',
            'model_id',
            'tag_id'
        )->withPivotValue('model_type', self::class);
    }

    public function faqs(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Faq::class, 'model');
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class, 'product_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function seller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->hasManyThrough(Attribute::class, AttributeProduct::class, 'product_id', 'attribute_id');
    }

    public function attributeProducts()
    {
        return $this->hasMany(AttributeProduct::class, 'product_id');
    }

    public function attributeValues()
    {
        return $this->hasManyThrough(AttributeValue::class, AttributeProduct::class, 'product_id', 'attribute_value_id');
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Review::class, 'model');
    }

    //    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    //    {
    //        return $this->belongsTo(Brand::class, 'brand_id');
    //    }

    //    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    //    {
    //        return $this->hasMany(ProductQuestion::class, 'product_id');
    //    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            related: Category::class,
            table: 'model_has_categories',
            foreignPivotKey: 'model_id',
            relatedPivotKey: 'category_id'
        )->withPivotValue('model_type', self::class);
    }

    /*
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', Status::PUBLISHED)->whereHas('children', function ($query) {
            $query->active();
        });
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }
}
