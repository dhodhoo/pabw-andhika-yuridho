<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
    // GET /api/books - publik
    public function index(): JsonResponse
    {
        return response()->json(Book::latest()->get(), 200);
    }

    // POST /api/books - wajib login, boleh membawa sampul
    public function store(StoreBookRequest $request): JsonResponse
    {
        $data = $request->safe()->only(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok']);

        if ($request->hasFile('cover')) {
            $data = [...$data, ...$this->storeCover($request->file('cover'))];
        }

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    // GET /api/books/{id} - publik
    public function show($id): JsonResponse
    {
        return response()->json($this->findBook($id), 200);
    }

    // PATCH /api/books/{id} - wajib login
    public function update(UpdateBookRequest $request, $id): JsonResponse
    {
        $book = $this->findBook($id);
        $data = $request->safe()->only(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok']);

        // ganti sampul: hapus yang lama lalu simpan yang baru
        if ($request->hasFile('cover')) {
            $this->deleteCover($book);
            $data = [...$data, ...$this->storeCover($request->file('cover'))];
        }

        // hapus sampul tanpa mengirim pengganti
        if ($request->boolean('remove_cover')) {
            $this->deleteCover($book);
            $data['cover_path'] = null;
            $data['cover_name'] = null;
        }

        $book->update($data);

        return response()->json($book, 200);
    }

    // DELETE /api/books/{id} - wajib login
    public function destroy($id): JsonResponse
    {
        $book = $this->findBook($id);
        $this->deleteCover($book);
        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    // GET /api/books/{id}/cover - publik, membuka file sampul
    public function cover($id): StreamedResponse|JsonResponse
    {
        $book = $this->findBook($id);

        if (! $book->cover_path || ! \Illuminate\Support\Facades\Storage::exists($book->cover_path)) {
            return response()->json(['message' => 'Sampul tidak ditemukan'], 404);
        }

        return \Illuminate\Support\Facades\Storage::download($book->cover_path, $book->cover_name);
    }

    private function findBook($id): Book
    {
        $book = Book::find($id);

        if (! $book) {
            abort(404, 'Buku tidak ditemukan');
        }

        return $book;
    }

    // simpan file ke storage/app/private/covers, kembalikan kolom untuk tabel books
    private function storeCover(\Illuminate\Http\UploadedFile $file): array
    {
        $path = $file->store('covers', 'local');

        return [
            'cover_path' => $path,
            'cover_name' => $file->getClientOriginalName(),
        ];
    }

    private function deleteCover(Book $book): void
    {
        if ($book->cover_path && \Illuminate\Support\Facades\Storage::exists($book->cover_path)) {
            \Illuminate\Support\Facades\Storage::delete($book->cover_path);
        }
    }
}
