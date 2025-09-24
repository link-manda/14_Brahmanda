    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Kategori Baru') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 2xl:max-w-screen-2xl">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form method="POST" action="{{ route('admin.kategori.store') }}">
                            @csrf
                            <!-- Nama Kategori -->
                            <div>
                                <x-input-label for="nama_kategori" value="Nama Kategori" />
                                <x-text-input id="nama_kategori" class="block mt-1 w-full" type="text" name="nama_kategori" :value="old('nama_kategori')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
                            </div>

                            <!-- Deskripsi -->
                            <div class="mt-4">
                                <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                                <textarea name="deskripsi" id="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('admin.kategori.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Batal
                                </a>
                                <x-primary-button class="ms-4">
                                    Simpan Kategori
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>