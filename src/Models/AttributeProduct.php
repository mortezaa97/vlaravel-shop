<?php

namespace Mortezaa97\Shop\Models;

use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
class AttributeProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $appends = [];

    protected $with = ['value'];


    protected static function boot(){
        parent::boot();
        static::creating(function ($item) {
            $item->attribute_name = $item->attribute->name;
            $item->attribute_slug = $item->attribute->slug;
            $item->attribute_value_title = $item->value->title;
        });
        static::updating(function ($item) {
            $item->attribute_name = $item->attribute->name;
            $item->attribute_slug = $item->attribute->slug;
            $item->attribute_value_title = $item->value->title;
        });
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
    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function value(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
