<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegistrRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Необходимо заполнить поле Логин',
            'login.string' => 'Логин должен быть строкой',
            'login.unique' => 'Пользователь с таким логином уже существует',
            'password.required' => 'Необходимо заполнить поле Пароль',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Минимальная длина пароля должна составлять 6 символов'
        ];
    }
    

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
