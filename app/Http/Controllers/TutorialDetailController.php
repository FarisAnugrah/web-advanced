<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialDetail;
use Illuminate\Http\Request;
use App\Events\TutorialStepStatusChanged;
use Illuminate\Support\Facades\Storage;

class TutorialDetailController extends Controller
{


    // Menampilkan semua detail dari sebuah tutorial
    public function index(Tutorial $tutorial)
    {
        // Mengambil semua detail yang berelasi dengan tutorial ini
        $details = $tutorial->details()->get();
        return view('details.index', compact('tutorial', 'details'));
    }

    // Menampilkan form untuk membuat detail baru
    public function create(Tutorial $tutorial)
    {
        return view('details.create', compact('tutorial'));
    }

    // Menyimpan detail baru ke database
    public function store(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'content_type' => 'required|in:text,image,code,url',
            'content_text' => 'nullable|string',
            'content_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
            'sort_order' => 'required|integer',
        ]);

        $data = $request->only('content_type', 'sort_order');
        $data['content_text'] = $request->input('content_text');

        if ($request->hasFile('content_image')) {
            // Simpan gambar ke public storage dan dapatkan path-nya
            $path = $request->file('content_image')->store('tutorial_images', 'public');
            $data['content_image_path'] = $path;
        }

        $tutorial->details()->create($data);

        return redirect()->route('tutorials.details.index', $tutorial)->with('success', 'Detail tutorial berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk sebuah detail
    public function edit(Tutorial $tutorial, TutorialDetail $detail)
    {
        return view('details.edit', compact('tutorial', 'detail'));
    }

    // Memperbarui data detail di database
    public function update(Request $request, Tutorial $tutorial, TutorialDetail $detail)
    {
        $request->validate([
            'content_type' => 'required|in:text,image,code,url',
            'content_text' => 'nullable|string',
            'content_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'required|integer',
        ]);

        $data = $request->only('content_type', 'sort_order');
        $data['content_text'] = $request->input('content_text');

        if ($request->hasFile('content_image')) {
            // Hapus gambar lama jika ada
            if ($detail->content_image_path) {
                Storage::disk('public')->delete($detail->content_image_path);
            }
            // Simpan gambar baru
            $path = $request->file('content_image')->store('tutorial_images', 'public');
            $data['content_image_path'] = $path;
        }

        $detail->update($data);

        return redirect()->route('tutorials.details.index', $tutorial)->with('success', 'Detail tutorial berhasil diperbarui.');
    }

    // Mengubah status show/hide
    public function toggleStatus(Tutorial $tutorial, TutorialDetail $detail)
{
    $newStatus = $detail->status == 'show' ? 'hide' : 'show';
    $detail->status = $newStatus;
    $detail->save();

    // ==========================================================
    // PERBAIKAN UTAMA: Panggil Event dengan DUA argumen
    // ==========================================================
    broadcast(new \App\Events\TutorialStepStatusChanged($detail->fresh(), $newStatus))->toOthers();

    return back()->with('success', 'Status berhasil diubah.');
}

    // Menghapus sebuah detail
    public function destroy(Tutorial $tutorial, TutorialDetail $detail)
    {
        // Hapus file gambar terkait jika ada
        if ($detail->content_image_path) {
            Storage::disk('public')->delete($detail->content_image_path);
        }
        $detail->delete();

        return redirect()->route('tutorials.details.index', $tutorial)->with('success', 'Detail tutorial berhasil dihapus.');
    }
}
