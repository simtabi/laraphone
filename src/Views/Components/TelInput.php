<?php

namespace Simtabi\Laraphone\Views\Components;

use Closure;
use Simtabi\Gesanda\Abstracts\FormInputTemplate;
use Simtabi\Gesanda\Traits\Form\HasValue;

class TelInput extends FormInputTemplate
{

    use HasValue;

    /** @SuppressWarnings(PHPMD.ExcessiveParameterList) */
    public function __construct(
        string                        $name                     = 'phone',
        string|null                   $id                       = null,
        string|false|null             $placeholder              = null,
        array|object|null             $bind                     = null,
        string|false|null             $label                    = null,
        bool|null                     $floatingLabel            = null,
        string|Closure|null           $prepend                  = null,
        string|Closure|null           $append                   = null,
        string|int|array|Closure|null $value                    = null,
        string|null                   $caption                  = null,
        bool|null                     $displayValidationSuccess = null,
        bool|null                     $displayValidationFailure = null,
        string|null                   $errorBag                 = null,
        array                         $locales                  = [null],
        bool                          $marginBottom             = true,
        string|null                   $nestedWireKey            = null,
        string                        $type                     = 'tel',
        bool                          $showInputError           = true,
    ) {

        if (empty($name)) {
            $name = 'phone-' . uniqid();
        }
        
        if (empty($id)) {
            $id = $name;
        }

        parent::__construct(
            $name,
            $id,
            $placeholder,
            $bind,
            $label,
            $floatingLabel,
            $prepend,
            $append,
            $value,
            $caption,
            $displayValidationSuccess,
            $displayValidationFailure,
            $errorBag,
            $locales,
            $marginBottom,
            $nestedWireKey,
            $type,
            $showInputError,
        );

    }

    protected function setViewPath(): string
    {
        $this->asIs = true;

        return 'laraphone::components.laraphone';
    }

}
