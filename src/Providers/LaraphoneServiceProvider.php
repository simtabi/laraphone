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

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(self::PATH.'config/laraphone.php', 'laraphone');

        $this->app->singleton('laraphone', function () {
            return new Laraphone();
        });
    }

    public function boot(): void
    {
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
    }

    private function declareBladeDirectives()
    {
        Blade::directive('laraphoneStyles', function () {
            return "<?php echo view('laraphone::assets')->withType('styles'); ?>";
        });
        Blade::directive('laraphoneScripts', function () {
            return "<?php echo view('laraphone::assets')->withType('scripts'); ?>";
        });
    }

}
