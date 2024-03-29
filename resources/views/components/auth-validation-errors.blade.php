@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'flow error-summary']) }}>
        <p class="center">
            @svg('gmdi-error-outline', 'icon-inline', ['aria-hidden' => 'true'])
            {{ __('hearth::auth.error_intro') }}
        </p>

        @foreach ($errors->all() as $error)
            <x-hearth-alert type="error">
                <p>{{ $error }}</p>
            </x-hearth-alert>
        @endforeach
    </div>
@endif
