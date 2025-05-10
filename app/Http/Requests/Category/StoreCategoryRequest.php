<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'slug' => ['nullable', 'string', 'alpha_dash', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'order' => ['nullable', 'int', 'min:0', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Prepare the request data for validation.
     *
     * This method is called before the request is validated.
     * It's a good place to cast boolean values from the request.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
        //     if (!$this->filled('slug') && $this->filled('name')) {
        //         $this->merge(['slug' => \Str::slug($this->input('name'))]);
        //     }
    }
}
