<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        

        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto p-6">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Kategori</label>
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="nama" value="{{ old('nama') ?? $kategori->nama }}" >
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
