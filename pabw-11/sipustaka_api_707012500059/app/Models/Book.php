<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'cover_path', 'cover_name'])]
#[Hidden(['cover_path'])]
class Book extends Model
{
    protected $appends = ['cover_url'];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // URL untuk membuka sampul, null jika buku tidak punya sampul
    protected function coverUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->cover_path
                ? url("/api/books/{$this->id}/cover")
                : null
        );
    }
}
