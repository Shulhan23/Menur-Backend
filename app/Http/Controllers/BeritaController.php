<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        return Berita::latest()->get();
    }

    public function show($id)
    {
        return Berita::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('storage/berita'), $namaFile);
            $data['gambar'] = $namaFile; // hanya simpan nama filenya
        }
    
        return Berita::create($data);
    }
    
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
    
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    
        if ($request->hasFile('gambar')) {
            // Hapus file lama jika ada
            if ($berita->gambar && file_exists(public_path('storage/berita/' . $berita->gambar))) {
                unlink(public_path('storage/berita/' . $berita->gambar));
            }
    
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('storage/berita'), $namaFile);
            $data['gambar'] = $namaFile;
        }
    
        $berita->update($data);
    
        return response()->json(['message' => 'Berita berhasil diperbarui', 'berita' => $berita]);
    }


    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();
        return response()->json(['message' => 'Berita dihapus']);
    }
}



