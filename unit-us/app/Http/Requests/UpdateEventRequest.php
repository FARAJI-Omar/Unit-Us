<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'sometimes|string|max:255',
            'description'   => 'sometimes|string',
            'location'      => 'sometimes|string|max:255',
            'date'          => 'sometimes|date',
            'points_reward' => 'sometimes|integer|min:0',
            'capacity'      => 'nullable|integer|min:1',
            'status'        => 'sometimes|in:open,completed,cancelled',
        ];
    }
}
