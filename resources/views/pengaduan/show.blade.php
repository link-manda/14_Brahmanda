<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Pengaduan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Detail Laporan -->
            <div class="lg:col-span-2 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-full">
                        <header class="pb-4 border-b dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $pengaduan->judul }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Dilaporkan pada {{ $pengaduan->created_at->format('d M Y, H:i') }}.
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">Status Laporan</h3>
                                <div class="mt-2">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                        @if ($pengaduan->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif
                                        @if ($pengaduan->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 @endif
                                        @if ($pengaduan->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                                        @if ($pengaduan->status == 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                                        {{ ucfirst($pengaduan->status) }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">Isi Laporan</h3>
                                <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $pengaduan->isi_laporan }}</p>
                            </div>

                            @if ($pengaduan->foto_bukti)
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">Lampiran Bukti</h3>
                                <a href="{{ Storage::url($pengaduan->foto_bukti) }}" target="_blank" class="mt-2 inline-block">
                                    {{-- Perbaikan Controller: Menghapus str_replace karena path sudah benar --}}
                                    <img src="{{ Storage::url($pengaduan->foto_bukti) }}" alt="Foto Bukti" class="rounded-lg max-w-sm hover:opacity-80 transition-opacity duration-300">
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
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
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Ditanggapi oleh: {{ $tanggapan->petugas->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $tanggapan->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $tanggapan->isi_tanggapan }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.44a.75.75 0 00-1.06 1.06L10.94 10l-3.06 3.06a.75.75 0 101.06 1.06L12 11.06l3.06 3.06a.75.75 0 001.06-1.06L13.06 10l3.06-3.06a.75.75 0 00-1.06-1.06L12 8.94 8.94 6.44z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada tanggapan dari petugas.
                                </p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>