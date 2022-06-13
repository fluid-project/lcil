<x-app-layout>
    <x-slot name="header">
        {{-- replace with the correct name from law and policy source --}}
        <h1 itemprop="name">{{ $lawPolicySource->name }}</h1>
    </x-slot>

    <dl>
        @php
            $jurisdictionName = get_jurisdiction_name($lawPolicySource->jurisdiction, $lawPolicySource->municipality)
        @endphp
        <dt>{{ __('Jurisdiction') }}</dt>
        <dd>{{ $jurisdictionName }}</dd>

        <dt>{{ __('Year in Effect') }}</dt>
        <dd>{{ $lawPolicySource->year_in_effect }}</dd>

        @isset($lawPolicySource->reference)
            <dt>{{ __('Reference') }}</dt>
            <dd><a href="{{ $lawPolicySource->reference }}">{{ $lawPolicySource->reference }}</a></dd>
        @endisset

        @isset($lawPolicySource->type)
            <dt>{{ __('Type') }}</dt>
            <dd>{{ $lawPolicySource->type->value }}</dd>
        @endisset

        @isset($lawPolicySource->is_core)
            <dt>{{ __('Effect on Legal Capacity') }}</dt>
            <dd>
                @if ($lawPolicySource->is_core)
                    {{ __('Core - directly affects legal capacity') }}
                @else
                    {{ __('Supplemental - indirectly affects legal capacity') }}
                @endif
            </dd>
        @endisset
    </dl>

    @if(count($lawPolicySource->provisions) > 0)
        <section>
            <h2>{{ __('Provisions') }}</h2>
            @foreach ($lawPolicySource->provisions as $provision)
                <h3>{{ __('Section / Subsection: :section', ['section' => $provision->section]) }}</h3>
                <p>{{ $provision->body }}</p>
                @isset($provision->reference)
                    <a href="{{ $provision->reference }}">{{ __('Section / Subsection: :section Reference', ['section' => $provision->section]) }}</a>
                @endisset
                @if (isset($provision->legal_capacity_approach) or isset($provision->decision_making_capability))
                    <h4>{{ __('Other Information') }}</h4>
                    <ul role="list">
                        @isset($provision->legal_capacity_approach)
                            <li>{{ __(':approach approach to legal capacity', ['approach' => $provision->legal_capacity_approach->value]) }}</li>
                        @endisset
                        @isset($provision->decision_making_capability)
                            <li>{{ __('Recognizes :capability decision making capability', ['capability' => $provision->decision_making_capability->value]) }}</li>
                        @endisset
                    </ul>
                @endif
                @if ($provision->is_subject_to_challenge or $provision->is_result_of_challenge)
                    <h4>{{ __('Legal Information') }}</h4>
                    <ul role="list">
                        @if($provision->is_subject_to_challenge)
                            <li>{{ __('This provision is, or has been, subject to a constitutional or other court challenge.') }}</li>
                        @else
                            <li>{{ __('This provision is the result of a court challenge.') }}</li>
                        @endif
                        @isset($provision->decision_type)
                            <li>{{ __('Type of Decision: :decision_types', ['decision_types' => implode(', ', $provision->decision_type)]) }}</li>
                        @endisset
                        @isset($provision->decision_citation)
                            <li>{{ __('Decision Citation: :citation', ['citation' => $provision->decision_citation]) }}</li>
                        @endisset
                    </ul>
                @endif
            @endforeach
        </section>
    @endif
</x-app-layout>
