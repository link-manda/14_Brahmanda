    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Proses Pengaduan: ') }} {{ $pengaduan->judul }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Detail Laporan -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Laporan dari: {{ $pengaduan->user->name }} (NIK: {{ $pengaduan->user->nik }})
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Dikirim pada {{ $pengaduan->created_at->format('d M Y, H:i') }}.
                        </p>
                    </header>
                    <div class="mt-6 space-y-4">
                        <!-- Konten detail sama seperti di sisi user -->
                        <div>
                            <h3 class="font-semibold text-gray-800">Isi Laporan</h3>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $pengaduan->isi_laporan }}</p>
                        </div>
                        @if ($pengaduan->foto_bukti)
                        <div>
                            <h3 class="font-semibold text-gray-800">Foto Bukti</h3>
                            <a href="{{ Storage::url(str_replace('public/', '', $pengaduan->foto_bukti)) }}" target="_blank">
                                <img src="{{ Storage::url(str_replace('public/', '', $pengaduan->foto_bukti)) }}" alt="Foto Bukti" class="mt-2 rounded-lg max-w-sm hover:opacity-80 transition">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Kolom Tanggapan & Aksi -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900">
                        Berikan Tanggapan & Ubah Status
                    </h2>
                    <!-- Tampilkan pesan sukses jika ada -->
                    @if (session('success'))
                    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.tanggapan.store', $pengaduan) }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="status" value="Ubah Status Laporan" />
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="pending" @selected($pengaduan->status == 'pending')>Pending</option>
                                <option value="diproses" @selected($pengaduan->status == 'diproses')>Diproses</option>
                                <option value="selesai" @selected($pengaduan->status == 'selesai')>Selesai</option>
                                <option value="ditolak" @selected($pengaduan->status == 'ditolak')>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="isi_tanggapan" value="Isi Tanggapan" />
                            <textarea name="isi_tanggapan" id="isi_tanggapan" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('isi_tanggapan') }}</textarea>
                            <x-input-error :messages="$errors->get('isi_tanggapan')" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Kirim Tanggapan') }}</x-primary-button>
                        </div>
                    </form>

                    <div class="mt-8 border-t pt-4">
                        <h3 class="font-semibold text-gray-900">Riwayat Tanggapan</h3>
                        @forelse ($pengaduan->tanggapan()->latest()->get() as $tanggapan)
                        <div class="mt-4 border-b pb-2">
                            <div class="flex justify-between items-center text-sm">
                                <p class="font-semibold text-gray-800">{{ $tanggapan->petugas->name }}</p>
                                <p class="text-xs text-gray-500">{{ $tanggapan->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="mt-1 text-gray-700 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                        </div>
                        @empty
                        <p class="mt-2 text-sm text-gray-500">Belum ada tanggapan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>