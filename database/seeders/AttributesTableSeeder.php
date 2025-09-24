<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributesTableSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
//            // فروشگاه موبایل
//            ['name' => 'رنگ', 'slug' => 'color', 'order' => 1, 'image' => 'files/attribute-color.png'],
//            ['name' => 'ظرفیت حافظه', 'slug' => 'storage-capacity', 'order' => 2, 'image' => null],
//            ['name' => 'برند', 'slug' => 'brand', 'order' => 3, 'image' => null],
//            ['name' => 'اندازه صفحه', 'slug' => 'screen-size', 'order' => 4, 'image' => null],
//            ['name' => 'سیستم‌عامل', 'slug' => 'operating-system', 'order' => 5, 'image' => null],
//            ['name' => 'حافظه رم', 'slug' => 'ram', 'order' => 6, 'image' => null],
//            ['name' => 'دوربین', 'slug' => 'camera', 'order' => null, 'image' => null],
//
//            // لباس‌فروشی
//            ['name' => 'اندازه', 'slug' => 'size', 'order' => 2, 'image' => 'files/attribute-size.png'],
//            ['name' => 'جنس', 'slug' => 'material', 'order' => 3, 'image' => null],
//            ['name' => 'سبک', 'slug' => 'style', 'order' => 4, 'image' => 'files/attribute-style.png'],
//            ['name' => 'فیت', 'slug' => 'fit', 'order' => 5, 'image' => null],
//            ['name' => 'طول آستین', 'slug' => 'sleeve-length', 'order' => null, 'image' => null],
//            ['name' => 'یقه', 'slug' => 'neckline', 'order' => null, 'image' => null],
//            ['name' => 'طرح', 'slug' => 'pattern', 'order' => null, 'image' => 'files/attribute-pattern.png'],

            // شیرینی‌فروشی
            ['name' => 'طعم', 'slug' => 'flavor', 'order' => 1, 'image' => 'files/attribute-flavor.png'],
            ['name' => 'نوع', 'slug' => 'type', 'order' => 2, 'image' => null],
            ['name' => 'وزن', 'slug' => 'weight', 'order' => 3, 'image' => null],
            ['name' => 'بسته‌بندی', 'slug' => 'packaging', 'order' => 4, 'image' => null],
            ['name' => 'مواد تشکیل‌دهنده', 'slug' => 'ingredients', 'order' => null, 'image' => null],
            ['name' => 'مناسبت', 'slug' => 'occasion', 'order' => null, 'image' => null],
            ['name' => 'شکل', 'slug' => 'shape', 'order' => null, 'image' => 'files/attribute-shape.png'],
        ];

        foreach ($attributes as $attribute) {
            DB::table('attributes')->updateOrInsert(
                ['slug' => $attribute['slug']],
                [
                    'name' => $attribute['name'],
                    'slug' => $attribute['slug'],
                    'order' => $attribute['order'],
                    'image' => $attribute['image'],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => User::role('admin')->first()?->id
            ]
            );
        }
    }
}
