@foreach($locales as $locale)
    @php
        $id                   = $getId($locale) ?: $getDefaultId($type, $locale);
        $label                = $getLabel($locale);
        $displayFloatingLabel = $shouldDisplayFloatingLabel();
        $placeholder          = $getPlaceholder($label, $locale);
        $value                = $getValue($locale);
        $prepend              = $getPrepend($locale);
        $append               = $getAppend($locale);
        $errorMessage         = $getErrorMessage($errors, $locale);
        $validationClass      = !empty($getValidationClass($errors, $locale)) ? $getValidationClass($errors, $locale) : '';
        $isWired              = $componentIsWired();
        $wiredKey             = !empty($getNestedWireKey()) ? $getNestedWireKey().'.'.$name : $name;
    @endphp

    {{-- Hidden phone input --}}
    <input
        type="hidden" {{ $attributes->wire('model') }} id="{{ $id }}" name="{{ $name }}"
        @if ($attributes->has('value'))
        value="{{ $attributes->get('value') }}"
        @endif
        autocomplete="off"
    >

    {{-- Tel input --}}

    <div @class(['form-floating' => $displayFloatingLabel, 'mb-3' => $marginBottom])  wire:ignore>
        @if(($prepend || $append) && ! $displayFloatingLabel)
            <x-gesanda::form-label :id="$id" class="form-label" :label="$label"/>
            <div class="input-group">
                @endif
                @if(! $prepend && ! $append && ! $displayFloatingLabel)
                    <x-gesanda::form-label :id="$id" class="form-label" :label="$label"/>
                @endif
                @if($prepend && ! $displayFloatingLabel)
                    <x-gesanda::form-addon :addon="$prepend"/>
                @endif

                <div class="{{$validationClass}} wire-validation " >
                        <input {{ $attributes->except('wire')->merge([
                        'wire:model' . $getComponentLivewireModifier() => $isWired && ! $hasComponentNativeLivewireModelBinding() ? ($locale ? $wiredKey . '.' . $locale : $wiredKey) : null,
                        'id'                                           => $id,
                        'class'                                        => 'iti--laraphone form-control ' .$validationClass. ' ' . $attributes->get('class'),
                        'type'                                         => $type,
                        'name'                                         => $isWired ? null : ($locale ? $name . '[' . $locale . ']' : $name),
                        'placeholder'                                  => $placeholder,
                        'data-locale'                                  => $locale,
                        'value'                                        => $isWired ? null : ($value ?? ''),
                        'aria-describedby'                             => $caption ? $id . '-caption' : null,
                        ]) }}

                               data-phone-input-id="{{ $id }}"
                               data-phone-input-name="{{ $name }}"
                               data-phone-input="#{{ $id }}"

                               @if ($attributes->has('value'))
                               value="{{ $attributes->get('value') }}"
                               @endif

                               @if ($attributes->has('phone-country-input'))
                               data-phone-country-input="{{ $attributes->get('phone-country-input') }}"
                               @endif

                               @if ($attributes->has('placeholder'))
                               placeholder="{{ $attributes->get('placeholder') }}"
                               @endif

                               @if ($attributes->has('required'))
                               required
                               @endif

                               @if ($attributes->has('disabled'))
                               disabled
                               @endif
                               autocomplete="off"
                        />
                </div>
                @if(! $prepend && ! $append && $displayFloatingLabel)
                    <x-gesanda::form-label :id="$id" class="form-label" :label="$label"/>
                @endif
                @if($append && ! $displayFloatingLabel)
                    <x-gesanda::form-addon :addon="$append"/>
                @endif

                @if($showInputError && !empty($errorMessage))
                    <x-gesanda::errors :message="$errorMessage"/>
                @endif

                @if (empty($errorMessage))
                    <x-gesanda::form-caption :inputId="$id" :caption="$caption"/>
                @endif

                @if(($prepend || $append) && ! $displayFloatingLabel)
            </div>
        @endif
    </div>
@endforeach
