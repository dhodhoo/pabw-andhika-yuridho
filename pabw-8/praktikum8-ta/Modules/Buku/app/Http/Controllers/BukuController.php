<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Buku\Http\Requests\StoreBukuRequest;
use Modules\Buku\Http\Requests\UpdateBukuRequest;
use Modules\Buku\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a paginated and searchable list of books.
     */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $bukus = Buku::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', '%'.$search.'%')
                        ->orWhere('penulis', 'like', '%'.$search.'%')
                        ->orWhere('penerbit', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('judul')
            ->paginate(5)
            ->withQueryString();

        return view('buku::index', [
            'bukus' => $bukus,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        return view('buku::create');
    }

    /**
     * Store a newly created book.
     */
    public function store(StoreBukuRequest $request): RedirectResponse
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the given book.
     */
    public function edit(Buku $buku): View
    {
        return view('buku::edit', ['buku' => $buku]);
    }

    /**
     * Update the given book.
     */
    public function update(UpdateBukuRequest $request, Buku $buku): RedirectResponse
    {
        $buku->update($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the given book.
     */
    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
