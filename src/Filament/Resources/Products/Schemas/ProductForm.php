<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Mortezaa97\Shop\Models\Product;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                Wizard\Step::make('اطلاعات پایه')
                    ->description('نام، کد و شناسه محصول')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        \App\Filament\Components\Form\NameTextInput::create()->required(),
                        \App\Filament\Components\Form\EnglishNameTextInput::create(),
                        \App\Filament\Components\Form\SlugTextInput::create()->required(),
                        \Filament\Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('parent_id')
                            ->label('شناسه محصول والد')
                            ->numeric(),
                        \App\Filament\Components\Form\ExcerptTextarea::create(),
                        \App\Filament\Components\Form\DescTextarea::create(),
                    ])
                    ->columns(2),

                Wizard\Step::make('دسته‌بندی و وضعیت')
                    ->description('دسته‌بندی‌ها و وضعیت محصول')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        \App\Filament\Components\Form\CategoriesSelect::create(Product::class)
                            ->required()
                            ->columnSpan(2),
                        \App\Filament\Components\Form\StatusSelect::create(Product::class),
                        \App\Filament\Components\Form\IsOriginalToggle::create()->required(),
                        \Filament\Forms\Components\TextInput::make('increase_step')
                            ->label('گام افزایش')
                            ->numeric()
                            ->required()
                            ->default(1),
                        \App\Filament\Components\Form\ViewsTextInput::create()->required(),
                        \App\Filament\Components\Form\CreatedBySelect::create()->required(),
                        \App\Filament\Components\Form\UpdatedBySelect::create(),
                    ])
                    ->columns(2),

                Wizard\Step::make('قیمت و موجودی')
                    ->description('قیمت‌گذاری و مدیریت موجودی')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('time_to_send')
                            ->label('زمان ارسال')
                            ->maxLength(255),
                        \App\Filament\Components\Form\DateFromDatePicker::create(),
                        \App\Filament\Components\Form\DateToDatePicker::create(),
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
