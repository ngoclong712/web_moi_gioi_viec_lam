<?php

namespace App\Http\Requests\Post;

use App\Enums\PostCurrencySalaryEnum;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'company' => [
                'nullable',
                'string',
            ],
            'language' => [
                'required',
                'array',
                'filled',
            ],
            'city' => [
                'required',
                'string',
                'filled',
            ],
            'district' => [
                'nullable',
                'string',
            ],
            'currency_salary' => [
                'required',
                'numeric',
                Rule::in(PostCurrencySalaryEnum::getValues()),
            ],
            'number_applicants' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'start_date' => [
                'nullable',
                'date',
                'before:end_date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
            ],
            'title' => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'filled',
                'min:3',
                'max:255',
                Rule::unique(Post::class),
            ]
        ];

        $rules['min_salary'] = [
            'nullable',
            'numeric',
        ];
        $rules['max_salary'] = [
            'nullable',
            'numeric',
        ];
        if (!empty($this->min_salary) && !empty($this->max_salary)) {
            $rules['min_salary'][] = 'lt:max_salary';
            $rules['max_salary'][] = 'gt:min_salary';
        }

        return $rules;
    }
}
