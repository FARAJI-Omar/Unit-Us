<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'fullname' => 'string|max:100',
        'email' => 'required|email|unique:unitus_central_db.users,email',
        'password' => 'required|min:6|confirmed',
        'entreprise_name' => 'required|string|max:100',
        'slug' => 'required|alpha_dash|unique:unitus_central_db.entreprises,slug',
    ];
    }
}
