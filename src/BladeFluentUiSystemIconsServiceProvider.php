<?php

declare(strict_types=1);

namespace Codeat3\BladeFluentUiSystemIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeFluentUiSystemIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-fluentui-system-icons', []);

            $factory->add('fluentui-system-icons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-fluentui-system-icons.php', 'blade-fluentui-system-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-fluentui-system-icons'),
            ], 'blade-fluentui-system-icons');

            $this->publishes([
                __DIR__ . '/../config/blade-fluentui-system-icons.php' => $this->app->configPath('blade-fluentui-system-icons.php'),
            ], 'blade-fluentui-system-icons-config');
        }
    }
}
