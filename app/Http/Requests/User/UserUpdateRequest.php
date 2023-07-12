<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'unique:users,email,'.$this->user?->id, 'email'],
            'phone' => ['required', 'string', 'unique:users,phone,'.$this->user?->id, 'min:10', 'max:20'],
        ];
    }
}
