<?php

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\Attribute;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Shop\Http\Resources\AttributeResource;
class AttributeController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Attribute::class);
        return AttributeResource::collection(Attribute::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Attribute::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeResource($attribute);
    }

    public function show(Attribute $attribute)
    {
        Gate::authorize('view', $attribute);
        return new AttributeResource($attribute);
    }

    public function update(Request $request, Attribute $attribute)
    {
        Gate::authorize('update', $attribute);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new AttributeResource($attribute);
    }

    public function destroy(Attribute $attribute)
    {
        Gate::authorize('delete', $attribute);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
