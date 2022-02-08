<?php

namespace Simtabi\Laraphone\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Simtabi\Laraphone\Laraphone;
use Simtabi\Laraphone\Views\Components\TelInput;

class LaraphoneServiceProvider extends ServiceProvider
{
    
    private const PACKAGE_NAME = 'laraphone';
    private const PATH         = __DIR__.'/../../';

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
        $this->app->singleton('laraphone', function () {
            return new Laraphone();
        });
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(self::PATH.'config/laraphone.php', 'laraphone');

        $this->loadViewsFrom(self::PATH . 'resources/views', self::PACKAGE_NAME);
        $this->loadTranslationsFrom(self::PATH . 'resources/lang', self::PACKAGE_NAME);

        $this->registerBladeComponents();
        $this->declareBladeDirectives();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::PATH . 'config/laraphone.php' => config_path('laraphone.php'),
            ], 'laraphone:config');

            $this->publishes([
                self::PATH . 'public'               => public_path('vendor/laraphone'),
            ], 'laraphone:assets');

            $this->publishes([
                self::PATH . 'resources/views'      => resource_path('views/vendor/laraphone'),
            ], 'laraphone:views');

            $this->publishes([
                self::PATH . 'resources/lang'       => resource_path('lang/vendor/courier'),
            ], 'laraphone:translations');
        }

    }

    private function registerBladeComponents()
    {
        Blade::component('laraphone::input', TelInput::class);

        View::composer('laraphone::assets', function ($view) {
            $view->laraphoneCssPath = __DIR__ . '/../../public/css/laraphone.css';
            $view->laraphoneJsPath  = __DIR__.'/../../public/js/laraphone.js';
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
}
