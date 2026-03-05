<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow if user is authenticated - proper ownership check is done in controller
        return $this->user() != null;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'name' => ['string', 'max:255'],
            'email' => [
                'email',
                'max:255',
                $userId ? "unique:users,email,{$userId}" : 'unique:users,email'
            ],
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ];
    }
}
