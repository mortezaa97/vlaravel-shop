<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Mortezaa97\Shop\Filament\Resources\Products\ProductResource;
use Mortezaa97\Shop\Filament\Resources\Products\Schemas\ProductForm;
use Mortezaa97\Shop\Models\Product;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    // Store children and attribute data temporarily
    protected array $childrenData = [];

    protected array $attributeProductsData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // We only save main product data here
        $this->childrenData = $data['children'] ?? [];

        // Extract attribute products data from children
        $this->attributeProductsData = [];
        foreach ($this->childrenData as $index => $child) {
            if (isset($child['attributeProducts'])) {
                $this->attributeProductsData[$index] = $child['attributeProducts'];
                unset($this->childrenData[$index]['attributeProducts']);
            }
        }

        // Remove children data from main product data
        unset($data['children']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Save related records after creating Product
        $product = $this->record;

        // Create children products
        foreach ($this->childrenData as $index => $childData) {
            $child = $product->children()->create($childData);

            // Create attribute products for this child
            if (isset($this->attributeProductsData[$index])) {
                foreach ($this->attributeProductsData[$index] as $attributeProductData) {
                    $child->attributeProducts()->create($attributeProductData);
                }
            }
        }
    }

    public function form(Schema $schema): Schema
    {
        // Build base sections schema from ProductForm and wrap into a wizard for create page
        $baseSchema = ProductForm::configure($schema);

        // Build wizard steps explicitly to avoid relying on internal component APIs
        return $schema->components([
            Wizard::make([
                Wizard\Step::make('اطلاعات پایه')
                    ->description('نام، کد و شناسه محصول')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        \App\Filament\Components\Form\NameTextInput::create()->required()->columnSpan(1),
                        \App\Filament\Components\Form\EnglishNameTextInput::create()->columnSpan(1),
                        \App\Filament\Components\Form\SlugTextInput::create()->required()->columnSpan(1),
                        \Filament\Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->maxLength(255)
                            ->columnSpan(1),
                        \Filament\Forms\Components\TextInput::make('parent_id')
                            ->label('شناسه محصول والد')
                            ->numeric()
                            ->columnSpan(1),
                        \App\Filament\Components\Form\ExcerptTextarea::create()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\DescTextarea::create()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Wizard\Step::make('دسته‌بندی و وضعیت')
                    ->description('دسته‌بندی‌ها و وضعیت محصول')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        \App\Filament\Components\Form\CategoriesSelect::create(Product::class)
                            ->required()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\StatusSelect::create(Product::class)->columnSpan(1),
                        \App\Filament\Components\Form\IsOriginalToggle::create()->required()->columnSpan(1),
                        \Filament\Forms\Components\TextInput::make('increase_step')
                            ->label('گام افزایش')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->columnSpan(1),
                        \App\Filament\Components\Form\ViewsTextInput::create()->required()->columnSpan(1),
                        \App\Filament\Components\Form\CreatedBySelect::create()->required()->columnSpan(1),
                        \App\Filament\Components\Form\UpdatedBySelect::create()->columnSpan(1),
                    ])
                    ->columns(2),

                Wizard\Step::make('قیمت و موجودی')
                    ->description('قیمت‌گذاری و مدیریت موجودی')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('time_to_send')
                            ->label('زمان ارسال')
                            ->maxLength(255)
                            ->columnSpan(2),
                        \App\Filament\Components\Form\DateFromDatePicker::create()->columnSpan(1),
                        \App\Filament\Components\Form\DateToDatePicker::create()->columnSpan(1),
                    ])
                    ->columns(2),

                Wizard\Step::make('تصاویر')
                    ->description('تصاویر و گالری محصول')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        \App\Filament\Components\Form\ImageFileUpload::create()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\HoverFileUpload::create()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\GalleryFileUpload::create()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Wizard\Step::make('تنوع‌های محصول')
                    ->description('افزودن تنوع‌ها و ویژگی‌های مختلف محصول')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('variants_info')
                            ->label('')
                            ->content('دسته‌بندی‌های محصول باید در مرحله قبل انتخاب شده باشند تا بتوانید ویژگی‌های تنوع را تعیین کنید.')
                            ->columnSpan(2),
                        \App\Filament\Components\Form\ProductChildrenRepeater::create()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Wizard\Step::make('سئو و بهینه‌سازی')
                    ->description('تنظیمات سئو و بهینه‌سازی')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        \App\Filament\Components\Form\MetaTitleTextInput::create()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\MetaDescTextarea::create()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\MetaKeywordsTagsInput::create()
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ])
                ->columnSpanFull()
                ->persistStepInQueryString()
                ->skippable(),
        ]);
    }
}
