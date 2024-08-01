<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Resep Baru') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Create Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            

            <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Resep</label>
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('nama') border-red-500 @enderror" id="nama" value="{{ old('nama') }}">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm @error('deskripsi') border-red-500 @enderror" id="deskripsi">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu Persiapan </label>
                    <input type="text" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_persiapan') border-red-500 @enderror" id="waktu_persiapan" value="{{ old('waktu_persiapan') }}">
                    @error('waktu_persiapan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu Memasak </label>
                    <input type="text" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_memasak') border-red-500 @enderror" id="waktu_memasak" value="{{ old('waktu_memasak') }}">
                    @error('waktu_memasak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pembuat_id" class="block text-gray-700 text-sm font-medium mb-1">Pembuat</label>
                    <select name="pembuat_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('pembuat_id') border-red-500 @enderror" id="pembuat_id">
                        <option value="">Pilih Pembuat</option>
                        @foreach($pembuat as $p)
                            <option value="{{ $p->id }}" {{ old('pembuat_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('pembuat_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('kategori_id') border-red-500 @enderror" id="kategori_id">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-medium mb-1">Gambar</label>
                    <input type="file" name="image" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror" id="image">
                    @error('image')
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
