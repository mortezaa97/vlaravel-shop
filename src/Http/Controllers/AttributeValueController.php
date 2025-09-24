<?php

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\AttributeValue;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Shop\Http\Resources\AttributeValueResource;
class AttributeValueController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', AttributeValue::class);
        return AttributeValueResource::collection(AttributeValue::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', AttributeValue::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeValueResource($attributeValue);
    }

    public function show(AttributeValue $attributeValue)
    {
        Gate::authorize('view', $attributeValue);
        return new AttributeValueResource($attributeValue);
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        Gate::authorize('update', $attributeValue);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeValueResource($attributeValue);
    }

    public function destroy(AttributeValue $attributeValue)
    {
        Gate::authorize('delete', $attributeValue);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
