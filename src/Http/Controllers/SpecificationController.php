<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Shop\Http\Resources\SpecificationResource;
use Mortezaa97\Shop\Models\Specification;

class SpecificationController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Specification::class);

        return SpecificationResource::collection(Specification::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Specification::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new SpecificationResource($specification);
    }

    public function show(Specification $specification)
    {
        Gate::authorize('view', $specification);

        return new SpecificationResource($specification);
    }

    public function update(Request $request, Specification $specification)
    {
        Gate::authorize('update', $specification);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return new SpecificationResource($specification);
    }

    public function destroy(Specification $specification)
    {
        Gate::authorize('delete', $specification);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), 419);
        }

        return response()->json('با موفقیت حذف شد');
    }
}
