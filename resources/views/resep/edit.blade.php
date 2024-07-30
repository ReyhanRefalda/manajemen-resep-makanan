<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Resep') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Edit Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <form action="{{ route('resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Resep</label>
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="nama" value="{{  $resep->nama }}" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" id="deskripsi" required>{{ $resep->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu Persiapan (menit)</label>
                    <input type="number" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="waktu_persiapan" value="{{ $resep->waktu_persiapan }}" required>
                </div>

                <div class="mb-4">
                    <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu Memasak (menit)</label>
                    <input type="number" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="waktu_memasak" value="{{  $resep->waktu_memasak }}" required>
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm" id="kategori_id" required>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $resep->kategori_id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-medium mb-1">Gambar</label>
                    @if($resep->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}" class="w-32 h-32 object-cover rounded-md shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="image">
                    <small class="text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah gambar.</small>
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
