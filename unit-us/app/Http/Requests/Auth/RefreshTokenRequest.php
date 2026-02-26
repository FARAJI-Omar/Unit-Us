<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->tokenCan('refresh');
    }

    public function rules(): array
    {
        return [];
    }
}
