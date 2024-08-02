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
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('nama') border-red-500 @enderror" id="nama" value="{{ $resep->nama }}">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm @error('deskripsi') border-red-500 @enderror" id="deskripsi">{{ $resep->deskripsi }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu Persiapan</label>
                    <input type="text" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_persiapan') border-red-500 @enderror" id="waktu_persiapan" value="{{ $resep->waktu_persiapan }}">
                    @error('waktu_persiapan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu Memasak</label>
                    <input type="text" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_memasak') border-red-500 @enderror" id="waktu_memasak" value="{{ $resep->waktu_memasak }}">
                    @error('waktu_memasak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pembuat_id" class="block text-gray-700 text-sm font-medium mb-1">Pembuat</label>
                    <select name="pembuat_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('pembuat_id') border-red-500 @enderror" id="pembuat_id">
                        @foreach($pembuat as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $resep->pembuat_id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('pembuat_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('kategori_id') border-red-500 @enderror" id="kategori_id">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $resep->kategori_id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bahan" class="block text-gray-700 text-sm font-medium mb-1">Pilih Bahan</label>
                    <select name="bahan[]" id="bahan" multiple="multiple" class="form-multiselect w-full border-gray-300 rounded-md shadow-sm @error('bahan') border-red-500 @enderror">
                        @foreach($bahans as $bahan)
                            <option value="{{ $bahan->id }}" {{ in_array($bahan->id, $resep->bahans->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $bahan->nama }}</option>
                        @endforeach
                    </select>
                    @error('bahan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="jumlah" class="block text-gray-700 text-sm font-medium mb-1">Jumlah Bahan</label>
                    @foreach($bahans as $bahan)
                        <input type="number" name="jumlah[{{ $bahan->id }}]" min="1" placeholder="Jumlah untuk {{ $bahan->nama }}" class="form-input w-full border-gray-300 rounded-md shadow-sm mb-2" value="{{ $resep->bahans->find($bahan->id)?->pivot->jumlah ?? '' }}">
                    @endforeach
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-medium mb-1">Gambar</label>
                    @if($resep->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}" class="w-32 h-32 object-cover rounded-md shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror" id="image">
                    <small class="text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah gambar.</small>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#bahan').select2({
                placeholder: "Pilih Bahan",
                allowClear: true
            });
        });
    </script>
</x-app-layout>
