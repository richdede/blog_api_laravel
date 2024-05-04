<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrUpdatePostRequest extends FormRequest
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
            'title' => ['string'],
            'description' => ['string'],
            'photo' => ['string'],
            'category_id' => ['exists:categories,id']
        ];

        // For POST requests (creating a new post), apply the unique rule and require title and description
        if ($this->isMethod('POST')) {
            $rules['title'][] = 'required';
            $rules['title'][] = Rule::unique('posts');
            $rules['description'][] = 'required';
        }

        return $rules;
    }
}
