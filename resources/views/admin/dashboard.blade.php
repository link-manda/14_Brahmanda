<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 2xl:max-w-screen-2xl">
            {{-- Bagian Kartu Statistik (tetap sama) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Card Total Pengaduan -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <x-icons.archive-box class="w-6 h-6 text-white" />
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Pengaduan</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>
                {{-- (Kartu lainnya tetap di sini) --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <x-icons.clock class="w-6 h-6 text-white" />
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pengaduan Pending</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <x-icons.cog-8-tooth class="w-6 h-6 text-white" />
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pengaduan Diproses</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['diproses'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <x-icons.check-circle class="w-6 h-6 text-white" />
                        </div>
                        <div class="ms-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pengaduan Selesai</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['selesai'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Tabel Pengaduan --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 md:mb-0">
                            Semua Pengaduan
                        </h3>
                        {{-- --- MULAI FORM FILTER & PENCARIAN --- --}}
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="w-full md:w-auto">
                            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2">
                                <div class="relative w-full md:w-64">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.magnifying-glass class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                                    </div>
                                    <input type="search" name="search" id="search" value="{{ request('search') }}" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Cari judul/pelapor...">
                                </div>
                                <select name="status" id="status" class="w-full md:w-auto text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                    <option value="">Semua Status</option>
                                    <option value="pending" @selected(request('status')=='pending' )>Pending</option>
                                    <option value="diproses" @selected(request('status')=='diproses' )>Diproses</option>
                                    <option value="selesai" @selected(request('status')=='selesai' )>Selesai</option>
                                    <option value="ditolak" @selected(request('status')=='ditolak' )>Ditolak</option>
                                </select>
                                <div class="flex items-center space-x-2">
                                    <x-primary-button type="submit">Filter</x-primary-button>
                                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-500">Reset</a>
                                </div>
                            </div>
                        </form>
                        {{-- --- AKHIR FORM FILTER & PENCARIAN --- --}}
                    </div>

                    <div class="relative overflow-x-auto mt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            {{-- ... (Isi tabel tetap sama, pastikan variabelnya $pengaduan) ... --}}
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul</th>
                                    <th scope="col" class="px-6 py-3">Pelapor</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengaduan as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ Str::limit($item->judul, 40) }}</th>
                                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($item->status == 'pending')
                                            <span class="h-2.5 w-2.5 bg-red-500 rounded-full me-2 animate-pulse-subtle"></span>
                                            @endif
                                            <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($item->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif
                                                @if ($item->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 @endif
                                                @if ($item->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                                                @if ($item->status == 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.pengaduan.show', $item) }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Proses</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada data pengaduan yang cocok.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination Link --}}
                    <div class="mt-4">
                        {{ $pengaduan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>