<?php

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\AttributeCategory;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Shop\Http\Resources\AttributeCategoryResource;
class AttributeCategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', AttributeCategory::class);
        return AttributeCategoryResource::collection(AttributeCategory::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', AttributeCategory::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeCategoryResource($attributeCategory);
    }

    public function show(AttributeCategory $attributeCategory)
    {
        Gate::authorize('view', $attributeCategory);
        return new AttributeCategoryResource($attributeCategory);
    }

    public function update(Request $request, AttributeCategory $attributeCategory)
    {
        Gate::authorize('update', $attributeCategory);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeCategoryResource($attributeCategory);
    }

    public function destroy(AttributeCategory $attributeCategory)
    {
        Gate::authorize('delete', $attributeCategory);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
