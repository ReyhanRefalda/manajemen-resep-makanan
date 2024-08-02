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
                    @if(is_array(old('bahan')))
                        @foreach(old('bahan') as $bahanId)
                            @php
                                $bahan = $bahans->find($bahanId);
                            @endphp
                            @if($bahan)
                                <div class="mb-2" id="jumlah-{{ $bahan->id }}">
                                    <label for="jumlah[{{ $bahan->id }}]" class="block text-gray-700 text-sm font-medium mb-1">Jumlah untuk {{ $bahan->nama }}</label>
                                    <input type="text" name="jumlah[{{ $bahan->id }}]" min="1" placeholder="Jumlah untuk {{ $bahan->nama }}" value="{{ old('jumlah.' . $bahan->id) }}" class="form-input w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            @endif
                        @endforeach
                    @endif
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
        $('#bahan').select2({
            placeholder: "Pilih Bahan",
            allowClear: true
        });

        let bahanList = {!! json_encode($bahans->toArray()) !!};

        // Function to populate jumlah fields
        function populateJumlahFields(selectedBahan) {
            let jumlahContainer = $('#jumlah-container');

            selectedBahan.forEach(function(id) {
                let bahan = bahanList.find(b => b.id == id);

                // Check if the field already exists
                if (bahan && !jumlahContainer.find(#jumlah-${bahan.id}).length) {
                    let existingValue = $('input[name="jumlah[' + id + ']"]').val() || '';
                    jumlahContainer.append(`
                        <div class="mb-2" id="jumlah-${bahan.id}">
                            <label for="jumlah[${bahan.id}]" class="block text-gray-700 text-sm font-medium mb-1">Jumlah untuk ${bahan.nama}</label>
                            <input type="text" name="jumlah[${bahan.id}]" min="1" placeholder="Jumlah untuk ${bahan.nama}" class="form-input w-full border-gray-300 rounded-md shadow-sm" value="${existingValue}">
                        </div>
                    `);
                }
            });
        }

        // On page load, populate fields if there are old values
        populateJumlahFields($('#bahan').val());

        // Event listener for changes in bahan selection
        $('#bahan').on('change', function() {
            let selectedBahan = $(this).val(); // Get selected bahan IDs
            let jumlahContainer = $('#jumlah-container');

            // Remove fields for bahan that are no longer selected
            jumlahContainer.find('div[id^="jumlah-"]').each(function() {
                let id = $(this).attr('id').replace('jumlah-', '');
                if (!selectedBahan.includes(id)) {
                    $(this).remove();
                }
            });

            // Populate fields for newly selected bahan
            populateJumlahFields(selectedBahan);
        });

        // Form submission validation
        $('#resepForm').on('submit', function(e) {
            let selectedBahan = $('#bahan').val();
            if (!selectedBahan || selectedBahan.length === 0) {
                e.preventDefault();
                alert('Pilih setidaknya satu bahan.');
                return;
            }

            // Validate that each selected bahan has a jumlah filled in
            let valid = true;
            selectedBahan.forEach(function(id) {
                let jumlahInput = $(input[name="jumlah[${id}]"]);
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

        // Restore the image input field value after form validation fails
        const imageInput = document.querySelector('input[name="image"]');
        if (imageInput) {
            // Save the file input to localStorage on change
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        localStorage.setItem('imageInput', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Restore the file input from localStorage
            const storedImageInput = localStorage.getItem('imageInput');
            if (storedImageInput) {
                const fileInputContainer = document.createElement('div');
                fileInputContainer.innerHTML = <input type="file" name="image" id="image" class="form-input w-full border-gray-300 rounded-md shadow-sm" />;
                const newFileInput = fileInputContainer.firstChild;
                newFileInput.addEventListener('change', imageInputEvent);
                imageInput.parentNode.replaceChild(newFileInput, imageInput);
                localStorage.removeItem('imageInput');
            }
        }
    });
    </script>

</x-app-layout>