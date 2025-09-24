    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tugaskan Kategori untuk Petugas: ') }} {{ $user->name }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">Pilih Kategori</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pilih satu atau lebih kategori yang akan menjadi tanggung jawab petugas ini.</p>
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($kategori as $item)
                                    <label for="kategori-{{ $item->id }}" class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <input
                                            id="kategori-{{ $item->id }}"
                                            type="checkbox"
                                            name="kategori_ids[]"
                                            value="{{ $item->id }}"
                                            @checked(in_array($item->id, $kategoriDitugaskan))
                                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $item->nama_kategori }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Batal
                                </a>
                                <x-primary-button class="ms-4">
                                    Simpan Penugasan
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>