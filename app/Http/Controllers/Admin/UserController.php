<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.users.create');
    }

    /**
     * Menyimpan petugas baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // Set role langsung sebagai petugas
            'email_verified_at' => now(), // Langsung verifikasi email
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Petugas baru berhasil ditambahkan.');
    }
}
