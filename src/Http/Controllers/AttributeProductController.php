<?php

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\AttributeProduct;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Shop\Http\Resources\AttributeProductResource;
class AttributeProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', AttributeProduct::class);
        return AttributeProductResource::collection(AttributeProduct::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', AttributeProduct::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeProductResource($attributeProduct);
    }

    public function show(AttributeProduct $attributeProduct)
    {
        Gate::authorize('view', $attributeProduct);
        return new AttributeProductResource($attributeProduct);
    }

    public function update(Request $request, AttributeProduct $attributeProduct)
    {
        Gate::authorize('update', $attributeProduct);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeProductResource($attributeProduct);
    }

    public function destroy(AttributeProduct $attributeProduct)
    {
        Gate::authorize('delete', $attributeProduct);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
