<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua admin dan petugas.
     */
    public function index(): View
    {
        $this->authorize('manage-system'); // <-- Tambahkan proteksi
        $users = User::whereIn('role', ['admin', 'petugas'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat petugas baru.
     */
    public function create(): View
    {
        $this->authorize('manage-system'); // <-- Tambahkan proteksi
        return view('admin.users.create');
    }

    /**
     * Menyimpan petugas baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('manage-system'); // <-- Tambahkan proteksi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Petugas baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk menugaskan kategori ke petugas.
     */
    public function edit(User $user)
    {
        $this->authorize('manage-system');

        $kategori = Kategori::all();
        $kategoriDitugaskan = $user->kategoriDitugaskan()->pluck('kategori.id')->toArray();

        return view('admin.users.edit', compact('user', 'kategori', 'kategoriDitugaskan'));
    }

    /**
     * Menyimpan perubahan penugasan kategori.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('manage-system');

        $request->validate([
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategori,id'
        ]);

        $user->kategoriDitugaskan()->sync($request->input('kategori_ids', []));

        return redirect()->route('admin.users.index')->with('success', 'Penugasan untuk ' . $user->name . ' berhasil diperbarui.');
    }
}
