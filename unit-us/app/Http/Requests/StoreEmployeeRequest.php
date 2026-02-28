<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tokenCan('access');
    }

    public function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:unitus_central_db.users,email',
        ];
    }
}
