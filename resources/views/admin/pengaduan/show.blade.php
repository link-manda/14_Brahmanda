<x-app-layout>
    <x-slot name="header">
        {{-- Perbaikan: Header yang lebih informatif dengan tombol kembali --}}
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Proses Detail Pengaduan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        {{-- Perbaikan: Menggunakan grid layout yang sama dengan halaman user --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri & Tengah: Detail Laporan & Form Aksi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Detail Laporan -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <header class="pb-4 border-b dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $pengaduan->judul }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Laporan dari <span class="font-semibold">{{ $pengaduan->user->name }}</span> (NIK: {{ $pengaduan->user->nik }})
                        </p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Dikirim pada {{ $pengaduan->created_at->format('d M Y, H:i') }}.
                        </p>
                    </header>
                    <div class="mt-6 space-y-6">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-gray-100">Isi Laporan</h3>
                            <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $pengaduan->isi_laporan }}</p>
                        </div>
                        @if ($pengaduan->foto_bukti)
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-gray-100">Lampiran Bukti</h3>
                            <a href="{{ Storage::url($pengaduan->foto_bukti) }}" target="_blank" class="mt-2 inline-block">
                                <img src="{{ Storage::url($pengaduan->foto_bukti) }}" alt="Foto Bukti" class="rounded-lg max-w-sm hover:opacity-80 transition-opacity duration-300">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Card Form Tanggapan -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Berikan Tanggapan & Ubah Status
                    </h2>

                    @if (session('success'))
                    <div class="mt-4 p-4 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 rounded-md">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.tanggapan.store', $pengaduan) }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="status" value="Ubah Status Laporan" />
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="pending" @selected($pengaduan->status == 'pending')>Pending</option>
                                <option value="diproses" @selected($pengaduan->status == 'diproses')>Diproses</option>
                                <option value="selesai" @selected($pengaduan->status == 'selesai')>Selesai</option>
                                <option value="ditolak" @selected($pengaduan->status == 'ditolak')>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="isi_tanggapan" value="Isi Tanggapan" />
                            <textarea name="isi_tanggapan" id="isi_tanggapan" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('isi_tanggapan') }}</textarea>
                            <x-input-error :messages="$errors->get('isi_tanggapan')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Kirim Tanggapan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Timeline Tanggapan -->
            <div class="lg:col-span-1">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Riwayat Tanggapan
                    </h2>
                    <div class="mt-6 space-y-6">
                        @forelse ($pengaduan->tanggapan()->latest()->get() as $tanggapan)
                        <div class="relative flex gap-x-4">
                            <div class="absolute left-0 top-0 flex w-8 justify-center -bottom-6">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div class="relative flex h-8 w-8 flex-none items-center justify-center bg-white dark:bg-gray-800">
                                <div class="h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 ring-2 ring-indigo-300 dark:ring-indigo-700 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-auto py-1.5">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $tanggapan->petugas->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $tanggapan->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Belum ada riwayat tanggapan untuk laporan ini.
                        </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>