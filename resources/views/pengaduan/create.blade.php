    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Pengaduan Baru') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-800">
                        <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Judul -->
                            <div>
                                <x-input-label for="judul" value="Judul Laporan" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            <!-- Isi Laporan -->
                            <div class="mt-4">
                                <x-input-label for="isi_laporan" value="Isi Laporan" />
                                <textarea name="isi_laporan" id="isi_laporan" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('isi_laporan') }}</textarea>
                                <x-input-error :messages="$errors->get('isi_laporan')" class="mt-2" />
                            </div>

                            <!-- Foto Bukti -->
                            <div class="mt-4">
                                <x-input-label for="foto_bukti" value="Foto Bukti (Opsional)" />
                                <input type="file" name="foto_bukti" id="foto_bukti" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <x-input-error :messages="$errors->get('foto_bukti')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Batal
                                </a>
                                <x-primary-button class="ms-4">
                                    Kirim Pengaduan
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>