<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Resep Baru') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Create Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <form id="resepForm" action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Resep -->
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Resep</label>
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('nama') border-red-500 @enderror" id="nama" value="{{ old('nama') }}">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm @error('deskripsi') border-red-500 @enderror" id="deskripsi">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Bahan -->
                <div class="mb-4">
                    <label for="bahan" class="block text-gray-700 text-sm font-medium mb-1">Pilih Bahan</label>
                    <select name="bahan[]" id="bahan" multiple="multiple" class="form-multiselect w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($bahans as $bahan)
                            <option value="{{ $bahan->id }}" {{ in_array($bahan->id, old('bahan', [])) ? 'selected' : '' }}>
                                {{ $bahan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('bahan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dynamic Jumlah Bahan Input Fields -->
                <div class="mb-4" id="jumlah-container">
                    <!-- Input fields will be dynamically added here -->
                </div>

                <!-- Other Fields -->
                <div class="mb-4">
                    <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu Persiapan</label>
                    <input type="text" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_persiapan') border-red-500 @enderror" id="waktu_persiapan" value="{{ old('waktu_persiapan') }}">
                    @error('waktu_persiapan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu Memasak</label>
                    <input type="text" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_memasak') border-red-500 @enderror" id="waktu_memasak" value="{{ old('waktu_memasak') }}">
                    @error('waktu_memasak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('kategori_id') border-red-500 @enderror">
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
                    <label for="pembuat_id" class="block text-gray-700 text-sm font-medium mb-1">Pembuat</label>
                    <select name="pembuat_id" id="pembuat_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('pembuat_id') border-red-500 @enderror">
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
                    <label for="image" class="block text-gray-700 text-sm font-medium mb-1">Image</label>
                    <input type="file" name="image" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror" id="image">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Select2
            $('#bahan').select2({
                placeholder: "Pilih Bahan",
                allowClear: true
            });

            let bahanList = {!! json_encode($bahans->toArray()) !!};
            let jumlahValues = {!! json_encode(old('jumlah', [])) !!}; // Fetch old input for 'jumlah'

            function populateJumlahFields(selectedBahan) {
                let jumlahContainer = $('#jumlah-container');
                jumlahContainer.empty(); // Clear existing fields

                selectedBahan.forEach(function(id) {
                    let bahan = bahanList.find(b => b.id == id);
                    if (bahan) {
                        let existingValue = jumlahValues[id] || ''; // Fetch value from the old input or set to empty
                        jumlahContainer.append(`
                            <div class="mb-2" id="jumlah-${bahan.id}">
                                <label for="jumlah[${bahan.id}]" class="block text-gray-700 text-sm font-medium mb-1">Jumlah untuk ${bahan.nama}</label>
                                <input type="text" name="jumlah[${bahan.id}]" min="1" placeholder="Jumlah untuk ${bahan.nama}" class="form-input w-full border-gray-300 rounded-md shadow-sm" value="${existingValue}">
                            </div>
                        `);
                    }
                });
            }

            // Handle change on bahan select
            $('#bahan').on('change', function() {
                let selectedBahan = $(this).val() || [];

                // Save current 'jumlah' values
                $('#jumlah-container input').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    let id = name.match(/\d+/)[0]; // Extract ID from input name
                    jumlahValues[id] = value;
                });

                populateJumlahFields(selectedBahan);
            });

            // Initialize jumlah fields based on selected bahan on page load
            let initialBahan = $('#bahan').val() || [];
            populateJumlahFields(initialBahan);

            $('#resepForm').on('submit', function(e) {
                let selectedBahan = $('#bahan').val();
                if (!selectedBahan || selectedBahan.length === 0) {
                    e.preventDefault();
                    alert('Pilih setidaknya satu bahan.');
                    return;
                }

                let valid = true;
                selectedBahan.forEach(function(id) {
                    let jumlahInput = $(`input[name="jumlah[${id}]"]`);
                    if (!jumlahInput.val()) {
                        valid = false;
                        jumlahInput.addClass('border-red-500');
                    } else {
                        jumlahInput.removeClass('border-red-500');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Jumlah untuk setiap bahan yang dipilih harus diisi.');
                }
            });
        });
    </script>
</x-app-layout>
