<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori']);
        Kategori::create($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id]);
        $kategori->update($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    
    public function destroy(Kategori $kategori)
    {
        // Cek jika kategori masih digunakan oleh pengaduan
        if ($kategori->pengaduan()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa pengaduan.');
        }
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}