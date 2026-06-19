<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Concerns;

trait PublishesPackageAssets
{
    protected function publishPackageAssets(string $tag): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $basePath = dirname((new \ReflectionClass($this))->getFileName());

        if (is_dir($basePath.'/Models')) {
            $this->publishes([
                $basePath.'/Models' => app_path('Models'),
            ], $tag.'-models');
        }

        if (is_dir($basePath.'/Filament')) {
            $this->publishes([
                $basePath.'/Filament' => app_path('Filament'),
            ], $tag.'-filament');
        }

        $migrationsPath = dirname($basePath).'/database/migrations';

        if (is_dir($migrationsPath)) {
            $this->publishes([
                $migrationsPath => database_path('migrations'),
            ], $tag.'-migrations');
        }
    }
}
