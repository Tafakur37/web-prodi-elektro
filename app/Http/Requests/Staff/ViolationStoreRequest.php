zz<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ViolationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role, ['staff', 'admin']);
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'not_in:' . auth()->id(),
                Rule::exists('users', 'id')->where('role', 'mahasiswa'),
            ],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'point' => 'required|integer|min:1|max:100',
            'date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:aktif,selesai'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.not_in' => 'Tidak bisa memilih diri sendiri.',
            'user_id.exists' => 'Mahasiswa yang dipilih tidak valid.',
            'date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
        ];
    }
}
