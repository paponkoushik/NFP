<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name'                 => 'bail|required|string|max:255|unique:categories',
            // slug regex
            'code'                 => 'bail|required|string|max:255|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:categories',
            'status'               => 'bail|required|string|in:active,inactive',
            'exclude_for'          => 'nullable|string|in:org,inv',
        ];

        if ($this->method() == 'PUT') {
            $rules['name'] = 'required|string|max:255|unique:categories,name,' . $this->route('category')->id;
            $rules['code'] = 'required|string|max:255|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:categories,code,' . $this->route('category')->id;
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'parent_id' => 'parent category',
        ];
    }

    public function messages()
    {
        return [
            'code.regex' => 'The code format is invalid. It should be in lowercase and separated by hyphen (-).',
        ];
    }
}
