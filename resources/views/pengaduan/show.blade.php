    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengaduan: ') }} {{ $pengaduan->judul }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Detail Laporan -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Informasi Laporan
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Detail laporan yang Anda kirimkan pada {{ $pengaduan->created_at->format('d M Y, H:i') }}.
                            </p>
                        </header>

                        <div class="mt-6 space-y-4">
                            <div>
                                <h3 class="font-semibold text-gray-800">Status</h3>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                    @if ($pengaduan->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if ($pengaduan->status == 'diproses') bg-blue-100 text-blue-800 @endif
                                    @if ($pengaduan->status == 'selesai') bg-green-100 text-green-800 @endif
                                    @if ($pengaduan->status == 'ditolak') bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Isi Laporan</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $pengaduan->isi_laporan }}</p>
                            </div>
                            @if ($pengaduan->foto_bukti)
                            <div>
                                <h3 class="font-semibold text-gray-800">Foto Bukti</h3>
                                <img src="{{ Storage::url(str_replace('public/', '', $pengaduan->foto_bukti)) }}" alt="Foto Bukti" class="mt-2 rounded-lg max-w-sm">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Tanggapan -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="text-lg font-medium text-gray-900">
                            Tanggapan Petugas
                        </h2>
                        @forelse ($pengaduan->tanggapan as $tanggapan)
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-semibold text-gray-800">Ditanggapi oleh: {{ $tanggapan->petugas->name }}</p>
                                <p class="text-xs text-gray-500">{{ $tanggapan->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                        </div>
                        @empty
                        <p class="mt-4 text-sm text-gray-500">
                            Belum ada tanggapan dari petugas.
                        </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>