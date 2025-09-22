<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Generate Laporan Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8 2xl:max-w-screen-2xl">
            {{-- Card untuk Filter Tanggal --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">
                        Filter Laporan
                    </h3>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Silakan pilih rentang tanggal untuk menampilkan preview laporan.
                    </p>
                    {{-- Form untuk menampilkan preview --}}
                    <form method="GET" action="{{ route('admin.laporan.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_awal" value="Dari Tanggal" />
                                <x-text-input id="tanggal_awal" class="block mt-1 w-full" type="date" name="tanggal_awal" :value="request('tanggal_awal')" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_akhir" value="Sampai Tanggal" />
                                <x-text-input id="tanggal_akhir" class="block mt-1 w-full" type="date" name="tanggal_akhir" :value="request('tanggal_akhir')" required />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                Tampilkan Preview
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Bagian Preview akan muncul jika ada data --}}
            @if ($pengaduan->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Preview Laporan
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Menampilkan {{ $pengaduan->count() }} pengaduan dari tanggal {{ \Carbon\Carbon::parse($tanggal_awal)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d M Y') }}.
                                </p>
                            </div>
                            {{-- Form untuk generate PDF --}}
                            <form method="POST" action="{{ route('admin.laporan.generate') }}" target="_blank" class="mt-4 md:mt-0">
                                @csrf
                                <input type="hidden" name="tanggal_awal" value="{{ $tanggal_awal }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ $tanggal_akhir }}">
                                <x-primary-button>
                                    <x-icons.document-text class="w-5 h-5 me-2" />
                                    <span>Generate PDF</span>
                                </x-primary-button>
                            </form>
                        </div>

                        {{-- Tabel Preview --}}
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">No</th>
                                        <th scope="col" class="px-6 py-3">Tanggal</th>
                                        <th scope="col" class="px-6 py-3">Pelapor</th>
                                        <th scope="col" class="px-6 py-3">Judul Laporan</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduan as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->user->name }}</th>
                                        <td class="px-6 py-4">{{ $item->judul }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($item->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif
                                                @if ($item->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 @endif
                                                @if ($item->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                                                @if ($item->status == 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif(request()->has('tanggal_awal'))
                {{-- Tampilan jika data tidak ditemukan --}}
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                       Tidak ada data pengaduan yang ditemukan pada periode tanggal yang dipilih.
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

