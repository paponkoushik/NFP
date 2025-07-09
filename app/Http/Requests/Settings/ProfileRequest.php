<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        return [
            'first_name' => 'bail|required|string|max:191',
            'last_name'  => 'bail|required|string|max:191',
            'phone'      => 'bail|nullable|string|max:191',
            'avatar'     => 'bail|nullable|image|max:800',
        ];
    }
}
