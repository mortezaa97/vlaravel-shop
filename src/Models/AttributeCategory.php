<?php

namespace Mortezaa97\Shop\Models;

use Mortezaa97\Shop\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class AttributeCategory extends Model
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
    protected $with = [];

    protected static function boot(){
        parent::boot();
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

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
