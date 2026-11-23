<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    // GET /api/posts - semua artikel
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    // GET /api/posts/{id} - satu artikel
    public function show($id)
    {
        return response()->json($this->findPost($id));
    }

    // POST /api/posts - tambah artikel (boleh dengan file)
    public function store(StorePostRequest $request): JsonResponse
    {
        $data = $request->safe()->only(['title', 'content']);
        // Jika ada file, simpan ke storage/app/private/posts

        if ($request->hasFile('file')) {
            $data = [...$data, ...$this->storeFile($request->file('file'))];
        }

        $post = $request->user()->posts()->create($data);
        return response()->json($post, 201);
    }

    // PATCH /api/posts/{id} - ubah artikel
    // Jika mengirim file, gunakan POST + field _method=PATCH
    public function update(UpdatePostRequest $request, int|string $id): JsonResponse
    {
        $post = $this->findOwnedPost($request, $id);
        $data = $request->safe()->only(['title', 'content']);
        if ($request->hasFile('file')) {
            // Ganti file lama dengan file baru
            $this->deleteFile($post);
            $data = [...$data, ...$this->storeFile($request->file('file'))];
        } elseif ($request->boolean('remove_file')) {
            // Hapus lampiran tanpa mengganti
            $this->deleteFile($post);
            $data = [...$data, 'file_path' => null, 'file_name' => null];
        }

        $post->update($data);
        return response()->json($post);
    }

    // DELETE /api/posts/{id} - hapus artikel beserta file-nya
    public function destroy(Request $request, int|string $id): JsonResponse
    {
        $post = $this->findOwnedPost($request, $id);
        $this->deleteFile($post);
        $post->delete();
        return response()->json(['message' => 'Post berhasil dihapus']);
    }

    // GET /api/posts/{id}/file - membuka / mengunduh file lampiran
    public function file(int|string $id): StreamedResponse
    {
        $post = $this->findPost($id);
        if (! $post->file_path || ! Storage::disk('local')->exists($post->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        // inline = gambar / PDF langsung dibuka di browser
        return Storage::disk('local')->response($post->file_path, $post->file_name, [], 'inline');
    }

    // Simpan file ke folder posts, kembalikan lokasi dan nama aslinya
    private function storeFile(UploadedFile $file): array
    {
        return [
            'file_path' => $file->store('posts', 'local'),
            'file_name' => $file->getClientOriginalName(),
        ];
    }

    // Hapus file lampiran lama dari storage (jika ada)
    private function deleteFile(Post $post): void
    {
        if ($post->file_path) {
            Storage::disk('local')->delete($post->file_path);
        }
    }

    // Hanya pemilik artikel yang boleh lanjut
    private function findOwnedPost(Request $request, $id)
    {
        $post = $this->findPost($id);
        if ($post->user_id != $request->user()->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah post ini');
        }
        return $post;
    }

    // Mencari artikel, jika tidak ada kirim 404
    private function findPost($id)
    {
        $post = Post::find($id);
        if (! $post) {
            abort(404, 'Post tidak ditemukan');
        }
        return $post;
    }
}
