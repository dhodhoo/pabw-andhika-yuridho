<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['sometimes', 'required', 'string', 'max:200'],
            'penulis' => ['sometimes', 'required', 'string', 'max:150'],
            'penerbit' => ['sometimes', 'required', 'string', 'max:150'],
            'tahun_terbit' => ['sometimes', 'required', 'integer', 'min:1900', 'max:' . (int) date('Y')],
            'stok' => ['sometimes', 'required', 'integer', 'min:0'],
            // kirim cover baru untuk mengganti sampul lama
            'cover' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
            // kirim remove_cover=1 untuk menghapus sampul
            'remove_cover' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'cover.max' => 'Ukuran sampul maksimal 2 MB.',
            'cover.mimes' => 'Format sampul harus jpg, jpeg, atau png.',
            'cover.uploaded' => 'Sampul gagal diunggah, periksa ukuran file.',
        ];
    }
}
