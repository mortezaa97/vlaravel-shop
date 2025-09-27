<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValuesTableSeeder extends Seeder
{
    public function run()
    {
        $attributeValues = [
//            // موبایل - رنگ
//            ['attribute_id' => 1, 'title' => 'قرمز', 'hex' => '#FF0000', 'desc' => 'رنگ قرمز جذاب و پررنگ'],
//            ['attribute_id' => 1, 'title' => 'آبی', 'hex' => '#0000FF', 'desc' => 'رنگ آبی آرامش‌بخش'],
//            ['attribute_id' => 1, 'title' => 'مشکی', 'hex' => '#000000', 'desc' => 'رنگ مشکی کلاسیک'],
//            ['attribute_id' => 1, 'title' => 'سفید', 'hex' => '#FFFFFF', 'desc' => 'رنگ سفید شیک'],
//            ['attribute_id' => 1, 'title' => 'طلایی', 'hex' => '#FFD700', 'desc' => 'رنگ طلایی لوکس'],
//
//            // موبایل - ظرفیت حافظه
//            ['attribute_id' => 2, 'title' => '64 گیگابایت', 'hex' => null, 'desc' => 'حافظه 64 گیگابایت برای استفاده روزمره'],
//            ['attribute_id' => 2, 'title' => '128 گیگابایت', 'hex' => null, 'desc' => 'حافظه 128 گیگابایت برای ذخیره‌سازی بیشتر'],
//            ['attribute_id' => 2, 'title' => '256 گیگابایت', 'hex' => null, 'desc' => 'حافظه 256 گیگابایت برای کاربران حرفه‌ای'],
//            ['attribute_id' => 2, 'title' => '512 گیگابایت', 'hex' => null, 'desc' => 'حافظه 512 گیگابایت برای حداکثر ظرفیت'],
//
//            // موبایل - برند
//            ['attribute_id' => 3, 'title' => 'سامسونگ', 'hex' => null, 'desc' => 'برند سامسونگ با کیفیت بالا'],
//            ['attribute_id' => 3, 'title' => 'اپل', 'hex' => null, 'desc' => 'برند اپل با طراحی شیک'],
//            ['attribute_id' => 3, 'title' => 'شیائومی', 'hex' => null, 'desc' => 'برند شیائومی با قیمت مناسب'],
//            ['attribute_id' => 3, 'title' => 'هواوی', 'hex' => null, 'desc' => 'برند هواوی با فناوری پیشرفته'],
//
//            // موبایل - اندازه صفحه
//            ['attribute_id' => 4, 'title' => '5.5 اینچ', 'hex' => null, 'desc' => 'صفحه نمایش 5.5 اینچ مناسب برای حمل'],
//            ['attribute_id' => 4, 'title' => '6.1 اینچ', 'hex' => null, 'desc' => 'صفحه نمایش 6.1 اینچ برای استفاده روزمره'],
//            ['attribute_id' => 4, 'title' => '6.7 اینچ', 'hex' => null, 'desc' => 'صفحه نمایش 6.7 اینچ برای تجربه بصری بهتر'],
//
//            // موبایل - سیستم‌عامل
//            ['attribute_id' => 5, 'title' => 'اندروید', 'hex' => null, 'desc' => 'سیستم‌عامل اندروید با انعطاف‌پذیری بالا'],
//            ['attribute_id' => 5, 'title' => 'iOS', 'hex' => null, 'desc' => 'سیستم‌عامل iOS با عملکرد روان'],
//
//            // موبایل - حافظه رم
//            ['attribute_id' => 6, 'title' => '4 گیگابایت', 'hex' => null, 'desc' => 'رم 4 گیگابایت برای عملکرد معمولی'],
//            ['attribute_id' => 6, 'title' => '6 گیگابایت', 'hex' => null, 'desc' => 'رم 6 گیگابایت برای عملکرد بهتر'],
//            ['attribute_id' => 6, 'title' => '8 گیگابایت', 'hex' => null, 'desc' => 'رم 8 گیگابایت برای عملکرد حرفه‌ای'],
//
//            // موبایل - دوربین
//            ['attribute_id' => 7, 'title' => '12 مگاپیکسل', 'hex' => null, 'desc' => 'دوربین 12 مگاپیکسل برای عکاسی معمولی'],
//            ['attribute_id' => 7, 'title' => '48 مگاپیکسل', 'hex' => null, 'desc' => 'دوربین 48 مگاپیکسل برای عکاسی با کیفیت بالا'],
//            ['attribute_id' => 7, 'title' => '108 مگاپیکسل', 'hex' => null, 'desc' => 'دوربین 108 مگاپیکسل برای عکاسی حرفه‌ای'],
//
//            // لباس‌فروشی - اندازه
//            ['attribute_id' => 8, 'title' => 'کوچک', 'hex' => null, 'desc' => 'اندازه کوچک مناسب افراد ریزاندام'],
//            ['attribute_id' => 8, 'title' => 'متوسط', 'hex' => null, 'desc' => 'اندازه متوسط برای اکثر افراد'],
//            ['attribute_id' => 8, 'title' => 'بزرگ', 'hex' => null, 'desc' => 'اندازه بزرگ برای راحتی بیشتر'],
//            ['attribute_id' => 8, 'title' => 'خیلی بزرگ', 'hex' => null, 'desc' => 'اندازه خیلی بزرگ برای سایزهای خاص'],
//
//            // لباس‌فروشی - جنس
//            ['attribute_id' => 9, 'title' => 'پنبه', 'hex' => null, 'desc' => 'جنس پنبه نرم و راحت'],
//            ['attribute_id' => 9, 'title' => 'پلی‌استر', 'hex' => null, 'desc' => 'جنس پلی‌استر مقاوم و سبک'],
//            ['attribute_id' => 9, 'title' => 'کتان', 'hex' => null, 'desc' => 'جنس کتان خنک و طبیعی'],
//            ['attribute_id' => 9, 'title' => 'ابریشم', 'hex' => null, 'desc' => 'جنس ابریشم لوکس و براق'],
//
//            // لباس‌فروشی - سبک
//            ['attribute_id' => 10, 'title' => 'رسمی', 'hex' => null, 'desc' => 'سبک رسمی برای مجالس'],
//            ['attribute_id' => 10, 'title' => 'روزمره', 'hex' => null, 'desc' => 'سبک روزمره برای استفاده روزانه'],
//            ['attribute_id' => 10, 'title' => 'ورزشی', 'hex' => null, 'desc' => 'سبک ورزشی برای فعالیت‌های بدنی'],
//
//            // لباس‌فروشی - فیت
//            ['attribute_id' => 11, 'title' => 'تنگ', 'hex' => null, 'desc' => 'فیت تنگ برای ظاهری شیک'],
//            ['attribute_id' => 11, 'title' => 'راحت', 'hex' => null, 'desc' => 'فیت راحت برای استفاده روزمره'],
//            ['attribute_id' => 11, 'title' => 'گشاد', 'hex' => null, 'desc' => 'فیت گشاد برای راحتی بیشتر'],
//
//            // لباس‌فروشی - طول آستین
//            ['attribute_id' => 12, 'title' => 'بدون آستین', 'hex' => null, 'desc' => 'بدون آستین برای فصول گرم'],
//            ['attribute_id' => 12, 'title' => 'آستین کوتاه', 'hex' => null, 'desc' => 'آستین کوتاه برای راحتی'],
//            ['attribute_id' => 12, 'title' => 'آستین بلند', 'hex' => null, 'desc' => 'آستین بلند برای فصول سرد'],
//
//            // لباس‌فروشی - یقه
//            ['attribute_id' => 13, 'title' => 'یقه گرد', 'hex' => null, 'desc' => 'یقه گرد کلاسیک'],
//            ['attribute_id' => 13, 'title' => 'یقه هفت', 'hex' => null, 'desc' => 'یقه هفت شیک'],
//            ['attribute_id' => 13, 'title' => 'یقه ایستاده', 'hex' => null, 'desc' => 'یقه ایستاده رسمی'],
//
//            // لباس‌فروشی - طرح
//            ['attribute_id' => 14, 'title' => 'ساده', 'hex' => null, 'desc' => 'طرح ساده و مینیمال'],
//            ['attribute_id' => 14, 'title' => 'چهارخانه', 'hex' => null, 'desc' => 'طرح چهارخانه کلاسیک'],
//            ['attribute_id' => 14, 'title' => 'راه‌راه', 'hex' => null, 'desc' => 'طرح راه‌راه جذاب'],

            // شیرینی‌فروشی - طعم
            ['attribute' => 'طعم', 'title' => 'شکلاتی', 'hex' => '#4B2D1E', 'desc' => 'طعم شکلاتی غنی'],
            ['attribute' => 'طعم', 'title' => 'وانیلی', 'hex' => '#F3E5AB', 'desc' => 'طعم وانیلی ملایم'],
            ['attribute' => 'طعم', 'title' => 'توت‌فرنگی', 'hex' => '#FF4040', 'desc' => 'طعم توت‌فرنگی تازه'],
            ['attribute' => 'طعم', 'title' => 'کاراملی', 'hex' => '#C68E17', 'desc' => 'طعم کاراملی شیرین'],

            // شیرینی‌فروشی - نوع
            ['attribute' => 'نوع', 'title' => 'کیک', 'hex' => null, 'desc' => 'کیک‌های متنوع برای مناسبت‌ها'],
            ['attribute' => 'نوع', 'title' => 'شیرینی خشک', 'hex' => null, 'desc' => 'شیرینی خشک ترد و خوشمزه'],
            ['attribute' => 'نوع', 'title' => 'دسر', 'hex' => null, 'desc' => 'دسرهای خامه‌ای و لذیذ'],

            // شیرینی‌فروشی - وزن
            ['attribute' => 'وزن', 'title' => '250 گرم', 'hex' => null, 'desc' => 'وزن 250 گرم برای مصرف فردی'],
            ['attribute' => 'وزن', 'title' => '500 گرم', 'hex' => null, 'desc' => 'وزن 500 گرم برای خانواده'],
            ['attribute' => 'وزن', 'title' => '1 کیلوگرم', 'hex' => null, 'desc' => 'وزن 1 کیلوگرم برای مهمانی‌ها'],

            // شیرینی‌فروشی - بسته‌بندی
            ['attribute' => 'بسته‌بندی', 'title' => 'جعبه مقوایی', 'hex' => null, 'desc' => 'بسته‌بندی مقوایی شیک'],
            ['attribute' => 'بسته‌بندی', 'title' => 'جعبه فلزی', 'hex' => null, 'desc' => 'بسته‌بندی فلزی بادوام'],
            ['attribute' => 'بسته‌بندی', 'title' => 'کیسه پلاستیکی', 'hex' => null, 'desc' => 'بسته‌بندی پلاستیکی ساده'],

            // شیرینی‌فروشی - مواد تشکیل‌دهنده
            ['attribute' => 'مواد تشکیل‌دهنده', 'title' => 'بدون گلوتن', 'hex' => null, 'desc' => 'مناسب برای رژیم بدون گلوتن'],
            ['attribute' => 'مواد تشکیل‌دهنده', 'title' => 'وگان', 'hex' => null, 'desc' => 'مناسب برای رژیم وگان'],
            ['attribute' => 'مواد تشکیل‌دهنده', 'title' => 'معمولی', 'hex' => null, 'desc' => 'شامل مواد استاندارد شیرینی'],

            // شیرینی‌فروشی - مناسبت
            ['attribute' => 'مناسبت', 'title' => 'عروسی', 'hex' => null, 'desc' => 'مناسب برای مراسم عروسی'],
            ['attribute' => 'مناسبت', 'title' => 'تولد', 'hex' => null, 'desc' => 'مناسب برای جشن تولد'],
            ['attribute' => 'مناسبت', 'title' => 'روزمره', 'hex' => null, 'desc' => 'مناسب برای مصرف روزانه'],

            // شیرینی‌فروشی - شکل
            ['attribute' => 'شکل', 'title' => 'گرد', 'hex' => null, 'desc' => 'شکل گرد کلاسیک'],
            ['attribute' => 'شکل', 'title' => 'مربع', 'hex' => null, 'desc' => 'شکل مربع مدرن'],
            ['attribute' => 'شکل', 'title' => 'قلب', 'hex' => null, 'desc' => 'شکل قلب برای مناسبت‌های خاص'],
        ];

        foreach ($attributeValues as $value) {
            $attribute = Attribute::where('name','LIKE','%'.$value['attribute'].'%')->first();
            DB::table('attribute_values')->updateOrInsert(
                [
                    'attribute_id' => $attribute->id,
                    'title' => $value['title'],
                ],
                [
                    'attribute_id' => $attribute->id,
                    'title' => $value['title'],
                    'hex' => $value['hex'],
                    'desc' => $value['desc'],
                    'created_by' => User::role('admin')->first()?->id
                ]
            );
        }
    }
}
