<?php

namespace Simtabi\Laraphone\Views\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Simtabi\Gesanda\Abstracts\AbstractComponent;
use Simtabi\Gesanda\Traits\Form\CanBeWired;
use Simtabi\Gesanda\Traits\Form\HasAddon;
use Simtabi\Gesanda\Traits\Form\HasFloatingLabel;
use Simtabi\Gesanda\Traits\Form\HasId;
use Simtabi\Gesanda\Traits\Form\HasLabel;
use Simtabi\Gesanda\Traits\Form\HasName;
use Simtabi\Gesanda\Traits\Form\HasPlaceholder;
use Simtabi\Gesanda\Traits\Form\HasValidation;
use Simtabi\Gesanda\Traits\Form\HasValue;

class TelInput extends AbstractComponent
{
    use HasId;
    use HasName;
    use HasLabel;
    use HasFloatingLabel;
    use HasValue;
    use HasPlaceholder;
    use HasAddon;
    use HasValidation;
    use CanBeWired;

    /** @SuppressWarnings(PHPMD.ExcessiveParameterList) */
    public function __construct(
        public    string                        $name                     = 'phone',
        protected string|null                   $id                       = null,
        public    string                        $type                     = 'tel',
        protected array|object|null             $bind                     = null,
        protected string|false|null             $label                    = null,
        protected bool|null                     $floatingLabel            = null,
        protected string|false|null             $placeholder              = null,
        protected string|Closure|null           $prepend                  = null,
        protected string|Closure|null           $append                   = null,
        protected string|int|array|Closure|null $value                    = null,
        public    string|null                   $caption                  = null,
        protected bool|null                     $displayValidationSuccess = null,
        protected bool|null                     $displayValidationFailure = null,
        protected string|null                   $errorBag                 = null,
        public    array                         $locales                  = [null],
        public    bool                          $marginBottom             = true
    ) {

        parent::__construct();

        if (!$this->name) {
            $this->name = 'phone-' . uniqid();
        }
        if (!$this->id) {
            $this->id = $this->name;
        }
    }

    protected function setViewPath(): string
    {
        $this->asIs = true;

        return 'laraphone::components.laraphone';
    }

}
