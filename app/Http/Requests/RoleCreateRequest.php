<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleCreateRequest extends FormRequest
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
            'role' => 'required|min:3|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'role' => 'Role Name'
        ];
    }

    public function messages()
    {
        return [
            'role.required' => "Field Role Is Required",
            'role.min' => 'Field Role Minimum :min Character',
            'role.max' => 'Field Role Minimum :max Character',
        ];
    }
}
