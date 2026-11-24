<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'penulis' => ['required', 'string', 'max:150'],
            'penerbit' => ['required', 'string', 'max:150'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . (int) date('Y')],
            'stok' => ['required', 'integer', 'min:0'],
            // sampul opsional, maksimal 2 MB (2048 KB)
            'cover' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_terbit.min' => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'cover.max' => 'Ukuran sampul maksimal 2 MB.',
            'cover.mimes' => 'Format sampul harus jpg, jpeg, atau png.',
            'cover.uploaded' => 'Sampul gagal diunggah, periksa ukuran file.',
        ];
    }
}
