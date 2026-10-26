<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uploads = Upload::where('user_id', Auth::id())->latest()->paginate(5);
        return view('uploads.index', compact('uploads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('uploads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        Upload::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path
        ]);

        return redirect()->route('uploads.index')->with('success', 'Berkas berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Upload $upload)
    {
        abort_if($upload->user_id !== Auth::id(), 403);
        return view('uploads.show', compact('upload'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Upload $upload)
    {
        abort_if($upload->user_id !== Auth::id(), 403);
        return view('uploads.edit', compact('upload'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Upload $upload)
    {
        abort_if($upload->user_id !== Auth::id(), 403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        $data = $request->only('judul', 'keterangan');

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($upload->filepath);
            $file = $request->file('file');
            $data['filename'] = $file->getClientOriginalName();
            $data['filepath'] = $file->store('uploads', 'public');
        }

        $upload->update($data);

        return redirect()->route('uploads.index')->with('success', 'Berkas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Upload $upload)
    {
        abort_if($upload->user_id !== Auth::id(), 403);

        Storage::disk('public')->delete($upload->filepath);
        $upload->delete();

        return redirect()->route('uploads.index')->with('success', 'Berkas berhasil dihapus.');
    }
}
