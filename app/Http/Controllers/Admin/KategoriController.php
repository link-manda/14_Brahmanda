<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage-system');
        $kategori = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create(): View
    {
        $this->authorize('manage-system');
        return view('admin.kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('manage-system');
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori']);
        Kategori::create($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        return redirect()->route('admin.kategori.edit', $kategori);
    }


    public function edit(Kategori $kategori): View
    {
        $this->authorize('manage-system');
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $this->authorize('manage-system');
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id]);
        $kategori->update($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        $this->authorize('manage-system');
        if ($kategori->pengaduan()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa pengaduan.');
        }
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
