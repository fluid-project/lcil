<?php

namespace App\Http\Requests;

use App\Enums\RegimeAssessmentStatuses;
use Illuminate\Validation\Rules\Enum;

class StoreRegimeAssessmentRequest extends RedirectFormRequest
{
    /**
     * The anchor on the redirect URL that users should be sent to if validation fails.
     *
     * @var string
     */
    protected $redirectAnchor = '#error-summary__message';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function attributes(): array
    {
        return [
            'country' => __('Country (country)'),
            'subdivision' => __('Province / Territory (subdivision)'),
            'municipality' => __('Municipality (municipality)'),
            'year_in_effect' => __('Year in Effect (year_in_effect)'),
            'description' => __('Description (description)'),
            'status' => __('Regime Assessment Status (status)'),
        ];
    }

    public function messages(): array
    {
        return [
            'country.min' => 'A :attribute, specified using an ISO 3166-1 alpha-2 country code, is required.',
            'country.required' => 'A :attribute, specified using an ISO 3166-1 alpha-2 country code, is required.',
            'subdivision.min' => 'The :attribute must be specified using the subdivision portion of an ISO 3166-2 code.',
            'subdivision.required_with' => 'The :attribute cannot be empty if the :values is specified.',
            'year_in_effect.integer' => 'The :attribute must be within '.config('settings.year.min').' and '.config('settings.year.max').'.',
            'year_in_effect.max' => 'The :attribute must be within '.config('settings.year.min').' and '.config('settings.year.max').'.',
            'year_in_effect.min' => 'The :attribute must be within '.config('settings.year.min').' and '.config('settings.year.max').'.',
            'year_in_effect.numeric' => 'The :attribute must be within '.config('settings.year.min').' and '.config('settings.year.max').'.',
            'status.required' => 'The :attribute must be one of the following: '.implode(', ', RegimeAssessmentStatuses::values()).'.',
            'status.Illuminate\Validation\Rules\Enum' => 'The :attribute must be one of the following: '.implode(', ', RegimeAssessmentStatuses::values()).'.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country' => ['required', 'min:2', 'string'],
            'subdivision' => ['required_with:municipality', 'nullable', 'min:2', 'string'],
            'municipality' => ['nullable', 'string'],
            'year_in_effect' => [
                'nullable',
                'numeric',
                'integer',
                'min:'.config('settings.year.min'),
                'max:'.config('settings.year.max'),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', new Enum(RegimeAssessmentStatuses::class)],
        ];
    }
}