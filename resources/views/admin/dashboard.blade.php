    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard - Semua Pengaduan') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $item->judul }}</th>
                                        <td class="px-6 py-4">{{ $item->user->name }}</td>
                                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($item->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if ($item->status == 'diproses') bg-blue-100 text-blue-800 @endif
                                                @if ($item->status == 'selesai') bg-green-100 text-green-800 @endif
                                                @if ($item->status == 'ditolak') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.pengaduan.show', $item) }}" class="font-medium text-indigo-600 hover:text-indigo-900">Proses</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data pengaduan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $pengaduan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>