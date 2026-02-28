<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tokenCan('access');
    }

    public function rules(): array
    {
        return [
            'fullname' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:unitus_central_db.users,email,' . $this->route('id'),
        ];
    }
}
