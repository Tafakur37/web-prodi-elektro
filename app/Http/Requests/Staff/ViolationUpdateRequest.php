<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class ViolationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['staff', 'admin']);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'point' => 'required|integer|min:1|max:100',
            'date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:aktif,selesai'
        ];
    }
}
