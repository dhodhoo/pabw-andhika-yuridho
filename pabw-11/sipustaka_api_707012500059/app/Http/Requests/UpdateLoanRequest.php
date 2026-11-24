<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_pinjam' => ['sometimes', 'required', 'date'],
            'tanggal_kembali' => ['sometimes', 'required', 'date', 'after_or_equal:tanggal_pinjam'],
            'status' => ['sometimes', 'required', 'in:Dipinjam,Dikembalikan'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
            'status.in' => 'Status hanya boleh Dipinjam atau Dikembalikan.',
        ];
    }
}
