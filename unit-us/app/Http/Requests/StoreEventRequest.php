<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'location'      => 'required|string|max:255',
            'date'          => 'required|date',
            'points_reward' => 'required|integer|min:0',
            'capacity'      => 'nullable|integer|min:1',
        ];
    }
}
