<?php

namespace App\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

final class UserRegistration extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    #[ArrayShape(['email'                 => "string[]",
                  'password'              => "string[]",
                  'password_confirmation' => "string[]"
    ])] public function rules(): array
    {
        return [
            'email'                 => ['required', 'email', 'unique:users'],
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
}
