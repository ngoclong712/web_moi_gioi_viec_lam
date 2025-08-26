<?php

namespace App\Http\Requests\Applicant\Homepage;

use App\Enums\PostRemotableEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
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
        return [
            'cities' => [
                'array',
                'nullable',
            ],
            'min_salary' => [
                'integer',
            ],
            'max_salary' => [
                'integer',
            ],
            'remotable' => [
                'nullable',
                Rule::in(PostRemotableEnum::asArray()),
            ]
        ];
    }
}
