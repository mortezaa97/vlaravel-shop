<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'product_name' => 'nullable|string|max:255',
            'category_url' => 'nullable|string|max:255',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'attributes' => 'nullable|array',
            'attributes.*' => 'string',
            'order' => 'nullable|string|in:newest,most_viewed,most_liked',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $minPrice = $this->input('min_price');
            $maxPrice = $this->input('max_price');

            if ($minPrice !== null && $maxPrice !== null && $maxPrice < $minPrice) {
                $validator->errors()->add('max_price', 'حداکثر قیمت باید بیشتر یا مساوی حداقل قیمت باشد.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'categories.array' => 'دسته‌بندی‌ها باید آرایه باشد.',
            'categories.*.integer' => 'هر دسته‌بندی باید عدد صحیح باشد.',
            'categories.*.exists' => 'دسته‌بندی انتخاب شده وجود ندارد.',
            'county_id.integer' => 'شناسه شهرستان باید عدد صحیح باشد.',
            'product_name.string' => 'نام محصول باید رشته باشد.',
            'product_name.max' => 'نام محصول نباید بیشتر از 255 کاراکتر باشد.',
            'district.string' => 'محله باید رشته باشد.',
            'district.max' => 'محله نباید بیشتر از 255 کاراکتر باشد.',
            'category_url.string' => 'آدرس دسته‌بندی باید رشته باشد.',
            'category_url.max' => 'آدرس دسته‌بندی نباید بیشتر از 255 کاراکتر باشد.',
            'min_price.numeric' => 'حداقل قیمت باید عدد باشد.',
            'min_price.min' => 'حداقل قیمت نمی‌تواند منفی باشد.',
            'max_price.numeric' => 'حداکثر قیمت باید عدد باشد.',
            'max_price.min' => 'حداکثر قیمت نمی‌تواند منفی باشد.',
            'max_price.gte' => 'حداکثر قیمت باید بیشتر یا مساوی حداقل قیمت باشد.',
            'attributes.array' => 'ویژگی‌ها باید آرایه باشد.',
            'attributes.*.string' => 'هر ویژگی باید رشته باشد.',
            'order.string' => 'ترتیب باید رشته باشد.',
            'order.in' => 'ترتیب باید یکی از مقادیر مجاز باشد.',
            'per_page.integer' => 'تعداد در صفحه باید عدد صحیح باشد.',
            'per_page.min' => 'تعداد در صفحه نمی‌تواند کمتر از 1 باشد.',
            'per_page.max' => 'تعداد در صفحه نمی‌تواند بیشتر از 100 باشد.',
        ];
    }
}
