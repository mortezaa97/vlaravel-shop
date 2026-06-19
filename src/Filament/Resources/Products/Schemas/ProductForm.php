<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Mortezaa97\Shop\Models\Product;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Main content (2/3)
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('اطلاعات پایه')
                        ->description('نام، کد و شناسه محصول')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            \App\Filament\Components\Form\NameTextInput::create()->required()->columnSpan(6),
                            \App\Filament\Components\Form\EnglishNameTextInput::create()->columnSpan(6),
                            \App\Filament\Components\Form\SlugTextInput::create()->required()->columnSpan(6),
                            \Filament\Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->maxLength(255)
                                ->columnSpan(6),
                            \Filament\Forms\Components\TextInput::make('parent_id')
                                ->label('شناسه محصول والد')
                                ->numeric()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\ExcerptTextarea::create()->columnSpan(12),
                            \App\Filament\Components\Form\DescTextarea::create()->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                    \Filament\Forms\Components\Select::make('brand_id')
                        ->label('برند')
                        ->relationship(
                            name: 'brand',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => $query->orderBy('name'),
                        )
                        ->searchable()
                        ->preload()
                        ->columnSpan(12)
                        ->required(fn () => class_exists(\Mortezaa97\Brands\Models\Brand::class))
                        ->visible(fn () => class_exists(\Mortezaa97\Brands\Models\Brand::class)),
                    \Filament\Schemas\Components\Section::make('قیمت و موجودی')
                        ->description('قیمت‌گذاری و مدیریت موجودی')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('time_to_send')
                                ->label('زمان ارسال')
                                ->maxLength(255)
                                ->columnSpan(12),
                            \App\Filament\Components\Form\DateFromDatePicker::create()->columnSpan(6),
                            \App\Filament\Components\Form\DateToDatePicker::create()->columnSpan(6),
                        ])
                        ->columns(12)
                        ->columnSpan(12),

                    \Filament\Schemas\Components\Section::make('تصاویر')
                        ->description('تصاویر و گالری محصول')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            \App\Filament\Components\Form\ImageFileUpload::create()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\HoverFileUpload::create()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\GalleryFileUpload::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),

                    \Filament\Schemas\Components\Section::make('تنوع‌های محصول')
                        ->description('افزودن تنوع‌ها و ویژگی‌های مختلف محصول')
                        ->icon('heroicon-o-cube')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('variants_info')
                                ->label('')
                                ->content('دسته‌بندی‌های محصول باید در مرحله قبل انتخاب شده باشند تا بتوانید ویژگی‌های تنوع را تعیین کنید.')
                                ->columnSpan(12),
                            \App\Filament\Components\Form\ProductChildrenRepeater::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),

                    \Filament\Schemas\Components\Section::make('سئو و بهینه‌سازی')
                        ->description('تنظیمات سئو و بهینه‌سازی')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            \App\Filament\Components\Form\MetaTitleTextInput::create()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\MetaDescTextarea::create()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\MetaKeywordsTagsInput::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),

            // Sidebar (1/3)
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('دسته‌بندی و وضعیت')
                        ->description('دسته‌بندی‌ها و وضعیت محصول')
                        ->icon('heroicon-o-folder')
                        ->schema([
                            \App\Filament\Components\Form\CategoriesSelect::create(Product::class)
                                ->required()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\StatusSelect::create(Product::class)->columnSpan(12),
                            \App\Filament\Components\Form\IsOriginalToggle::create()->required()->columnSpan(12),
                            \Filament\Forms\Components\TextInput::make('increase_step')
                                ->label('گام افزایش')
                                ->numeric()
                                ->required()
                                ->default(1)
                                ->columnSpan(12),
                            \App\Filament\Components\Form\ViewsTextInput::create()->required()->columnSpan(12),
                            \App\Filament\Components\Form\CreatedBySelect::create()->required()->columnSpan(12),
                            \App\Filament\Components\Form\UpdatedBySelect::create()->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
