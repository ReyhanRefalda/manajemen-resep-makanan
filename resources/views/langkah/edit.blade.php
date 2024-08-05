<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Langkah untuk Resep') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">

            <!-- Display error message -->
            @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <!-- Display success message -->
            @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('langkah.update', $langkah->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="resep_id" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                    <select name="resep_id" id="resep_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('resep_id') border-red-500 @enderror">
                        @foreach ($resep as $res)
                        <option value="{{ $res->id }}" {{ $langkah->resep_id == $res->id ? 'selected' : '' }}>{{ $res->nama }}</option>
                        @endforeach
                    </select>
                    @error('resep_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nomor" class="block text-gray-700 text-sm font-medium mb-1">Nomor Langkah</label>
                    <input type="number" name="nomor" id="nomor" value="{{ old('nomor', $langkah->nomor) }}" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('nomor') border-red-500 @enderror" placeholder="Nomor Langkah">
                    @error('nomor')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi Langkah</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm @error('deskripsi') border-red-500 @enderror" placeholder="Deskripsi Langkah" rows="3">{{ old('deskripsi', $langkah->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex space-x-4 mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>