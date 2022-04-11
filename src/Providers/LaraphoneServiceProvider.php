<?php

namespace Simtabi\Laraphone\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Simtabi\Laraphone\Laraphone;
use Simtabi\Laraphone\Views\Components\TelInput;

class LaraphoneServiceProvider extends ServiceProvider
{
    
    private string $packageName = 'laraphone';
    private const  PACKAGE_PATH = __DIR__.'/../../';

    public static array $cdnAssets = [
        'css'  => [
            '//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css'
        ],
        'js' => [
            '//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput.min.js'
        ],
    ];

    public static array $assets    = [
        'css'  => [
            'laraphone.css',
        ],
        'js' => [
            'laraphone.js',
        ],
    ];

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->loadTranslationsFrom(self::PACKAGE_PATH . "resources/lang/", $this->packageName);
        $this->loadMigrationsFrom(self::PACKAGE_PATH.'database/migrations');
        $this->loadViewsFrom(self::PACKAGE_PATH . "resources/views", $this->packageName);
        $this->mergeConfigFrom(self::PACKAGE_PATH . "config/config.php", $this->packageName);

        $this->app->singleton('laraphone', function () {
            return new Laraphone();
        });
    }

    public function boot(): void
    {
        $this->registerBladeComponents();
        $this->declareBladeDirectives();
        $this->registerConsoles();
    }

    private function registerBladeComponents()
    {
        Blade::component('laraphone::input', TelInput::class);

        View::composer('laraphone::assets', function ($view) {
            $view->laraphoneCssPath = self::PACKAGE_PATH . 'public/css/laraphone.css';
            $view->laraphoneJsPath  = self::PACKAGE_PATH.'public/js/laraphone.js';
        });

        Blade::include('laraphone::scripts', 'laraphoneScripts');
        Blade::include('laraphone::styles', 'laraphoneStyles');
    }

    private function declareBladeDirectives()
    {
        Blade::directive('laraphoneCss', function () {
            $styles  = $this->getComponentCdnStyles();
            $styles .= $this->getComponentStyles();
            return $styles;
        });

        Blade::directive('laraphoneJs', function () {
            $scripts  = $this->getComponentCdnScripts();
            $scripts .= $this->getComponentScripts();
            return $scripts;
        });
    }

    private function getComponentStyles()
    {
        $styles = self::$assets['css'] ?? [];

        if (is_array($styles) && (count($styles) >= 1)) {
            return collect($styles)->map(function($item) {
                return asset("/vendor/laraphone/css/{$item}");
            })->flatten()->map(function($styleUrl) {
                return '<link media="all" type="text/css" rel="stylesheet" href="' . $styleUrl . '">';
            })->implode(PHP_EOL);
        }

        return false;
    }

    private function getComponentScripts()
    {
        $scripts = self::$assets['js'] ?? [];

        if (is_array($scripts) && (count($scripts) >= 1)) {
            return collect($scripts)->map(function($item) {
                return asset("/vendor/laraphone/js/{$item}");
            })->flatten()->map(function($scriptUrl) {
                return !empty($scriptUrl) ? '<script src="' . $scriptUrl . '"></script>' : '';
            })->implode(PHP_EOL);
        }

        return false;
    }

    private function getComponentCdnStyles()
    {
        $styles = self::$cdnAssets['css'] ?? [];

        if (is_array($styles) && (count($styles) >= 1)) {

            return collect($styles)->map(function($item) {
                return $item;
            })->flatten()->map(function($styleUrl) {
                return !empty($styleUrl) ? '<link media="all" type="text/css" rel="stylesheet" href="' . $styleUrl . '">' : '';
            })->implode(PHP_EOL);
        }

        return false;
    }

    private function getComponentCdnScripts()
    {

        $scripts = self::$cdnAssets['js'] ?? [];

        if (is_array($scripts) && (count($scripts) >= 1)) {
            return collect($scripts)->map(function($item) {
                return $item;
            })->flatten()->map(function($scriptUrl) {
                return !empty($scriptUrl) ? '<script src="' . $scriptUrl . '"></script>' : '';
            })->implode(PHP_EOL);
        }

        return false;
    }

    private function registerConsoles(): static
    {
        if ($this->app->runningInConsole())
        {

            $this->publishes([
                self::PACKAGE_PATH . "config/config.php"               => config_path("{$this->packageName}.php"),
            ], "{$this->packageName}:config");

            $this->publishes([
                self::PACKAGE_PATH . "public"                          => public_path("vendor/{$this->packageName}"),
            ], "{$this->packageName}:assets");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views"                 => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/lang"                  => $this->app->langPath("vendor/{$this->packageName}"),
            ], "{$this->packageName}:translations");
        }

        return $this;
    }

}
