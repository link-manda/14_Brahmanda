<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Proses Pengaduan: ') }} {{ Str::limit($pengaduan->judul, 30) }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 2xl:max-w-screen-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Utama (Detail & Form) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Detail Laporan -->
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Laporan dari: <span class="font-bold">{{ $pengaduan->user->name }}</span> (NIK: {{ $pengaduan->user->nik }})
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Dikirim pada {{ $pengaduan->created_at->format('d M Y, H:i') }}.
                            </p>
                        </header>
                        <div class="mt-6 space-y-4">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">Kategori</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">
                                    {{ $pengaduan->kategori->nama_kategori ?? 'Tidak Berkategori' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">Isi Laporan</h3>
                                <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $pengaduan->isi_laporan }}</p>
                            </div>
                            @if ($pengaduan->foto_bukti)
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">Foto Bukti</h3>
                                <a href="{{ Storage::url($pengaduan->foto_bukti) }}" target="_blank">
                                    <img src="{{ Storage::url($pengaduan->foto_bukti) }}" alt="Foto Bukti" class="mt-2 rounded-lg max-w-sm hover:opacity-80 transition border dark:border-gray-700">
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form Tanggapan & Aksi -->
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Berikan Tanggapan & Ubah Status
                        </h2>
                        @if (session('success'))
                        <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-md">
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

                <!-- Kolom Samping (Riwayat Tanggapan) -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg h-fit">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Riwayat Tanggapan</h3>
                    <div class="mt-4 space-y-6">
                        @forelse ($pengaduan->tanggapan()->latest()->get() as $tanggapan)
                        <div class="relative flex gap-x-3">
                            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                                <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-gray-800">
                                <div class="h-1.5 w-1.5 rounded-full bg-gray-100 dark:bg-gray-700 ring-1 ring-gray-300 dark:ring-gray-600"></div>
                            </div>
                            <div class="flex-auto pb-6">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Ditanggapi oleh <span class="font-medium text-gray-900 dark:text-gray-100">{{ $tanggapan->petugas->name }}</span>
                                </p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $tanggapan->isi_tanggapan }}</p>
                                <time class="flex-none py-0.5 text-xs leading-5 text-gray-500 dark:text-gray-400">{{ $tanggapan->created_at->diffForHumans() }}</time>
                            </div>
                        </div>
                        @empty
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada tanggapan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>