
<div wire:ignore>
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
            $validationClass      = $getValidationClass($errors, $locale);
            $isWired              = $componentIsWired();
            $wiredKey             = !empty($getWireNestedKey()) ? $getWireNestedKey().'.'.$name : $name;
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

        <div @class(['form-floating' => $displayFloatingLabel, 'mb-3' => $marginBottom])>
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
                <input {{ $attributes->except('wire')->merge([
                'wire:model' . $getComponentLivewireModifier() => $isWired && ! $hasComponentNativeLivewireModelBinding() ? ($locale ? $wiredKey . '.' . $locale : $wiredKey) : null,
                'id'                                           => $id,
                'class'                                        => 'iti--laraphone form-control' . ($validationClass ? ' ' . $validationClass : null) . ' ' . $attributes->get('class'),
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
                @if(! $prepend && ! $append && $displayFloatingLabel)
                        <x-gesanda::form-label :id="$id" class="form-label" :label="$label"/>
                    @endif
                    @if($append && ! $displayFloatingLabel)
                        <x-gesanda::form-addon :addon="$append"/>
                    @endif
                <x-gesanda::form-caption :inputId="$id" :caption="$caption"/>
                <x-gesanda::error :message="$errorMessage"/>
                @if(($prepend || $append) && ! $displayFloatingLabel)
            </div>
            @endif
    </div>
    @endforeach
</div>







