<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Resep') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-4">
                    <button type="button" class="tab-button py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="resep">
                        Resep
                    </button>
                    <button type="button" class="tab-button py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="langkah">
                        Langkah
                    </button>
                </nav>
            </div>

            <div class="mt-4">
                <div id="resep-tab" class="tab-content">
                    <!-- Form untuk mengedit resep -->
                    <form id="resepForm" action="{{ route('resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Form fields untuk mengedit resep -->
                        <!-- Nama Resep -->
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Resep</label>
                            <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="nama" value="{{ old('nama') ?? $resep->nama }}">
                            @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" id="deskripsi">{{ old('deskripsi') ?? $resep->deskripsi }}</textarea>
                            @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pilih Bahan -->
                        <div class="mb-4">
                            <label for="bahan" class="block text-gray-700 text-sm font-medium mb-1">Pilih Bahan</label>
                            <select name="bahan[]" id="bahan" multiple="multiple" class="form-multiselect w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($bahans as $bahan)
                                <option value="{{ $bahan->id }}" {{ in_array($bahan->id, old('bahan', $resep->bahans->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ old('nama') ?? $bahan->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('bahan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Bahan -->
                        <div id="jumlah-container">
                            @foreach($resep->bahans as $bahan)
                            <div class="mb-4 jumlah-bahan" data-bahan-id="{{ $bahan->id }}">
                                <label for="jumlah_{{ $bahan->id }}" class="block text-gray-700 text-sm font-medium mb-1">Jumlah {{ $bahan->nama }}</label>
                                <input type="text" name="jumlah[{{ $bahan->id }}]" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="jumlah_{{ $bahan->id }}" value="{{ old('jumlah.' . $bahan->id, $bahan->pivot->jumlah) }}">
                            </div>
                            @endforeach
                        </div>

                        <!-- Waktu Persiapan -->
                        <div class="mb-4">
                            <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu Persiapan</label>
                            <input type="text" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="waktu_persiapan" value="{{ old('waktu_persiapan') ?? $resep->waktu_persiapan }}">
                            @error('waktu_persiapan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Memasak -->
                        <div class="mb-4">
                            <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu Memasak</label>
                            <input type="text" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="waktu_memasak" value="{{ old('waktu_memasak')?? $resep->waktu_memasak }}">
                            @error('waktu_memasak')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $resep->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pembuat -->
                        <div class="mb-4">
                            <label for="pembuat_id" class="block text-gray-700 text-sm font-medium mb-1">Pembuat</label>
                            <select name="pembuat_id" id="pembuat_id" class="form-select w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Pembuat</option>
                                @foreach($pembuat as $p)
                                <option value="{{ $p->id }}" {{ old('pembuat_id', $resep->pembuat_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                            @error('pembuat_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-medium mb-1">Gambar</label>
                            <input type="file" name="image" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="image">
                            <p class="text-gray-500 text-xs mt-1">Kosongkan kolom ini jika tidak ingin mengubah gambar.</p>
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

                <div id="langkah-tab" class="tab-content hidden">
                    <!-- Form untuk mengedit langkah -->
                    <form id="langkahForm" action="{{ route('langkah.update', $resep->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Resep -->
                        <div class="mb-4">
                            <label for="resep_id_display" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                            <input type="text" id="resep_id_display" class="form-input w-full border-gray-300 rounded-md shadow-sm" disabled value="{{ $resep->nama }}">
                        </div>

                        <!-- Kontainer Langkah -->
                        <div id="steps-container" class="flex flex-col space-y-4">
                            @foreach($langkahs as $index => $langkah)
                            <div class="mb-4 langkah-item" data-langkah-id="{{ $langkah->id }}">
                                <label for="langkah_{{ $langkah->id }}" class="block text-gray-700 text-sm font-medium mb-1">Langkah {{ $index + 1 }}</label>
                                <textarea name="langkah[{{ $langkah->id }}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm">{{ old('langkah.' . $langkah->id . '.deskripsi', $langkah->deskripsi) }}</textarea>
                                <input type="hidden" name="langkah[{{ $langkah->id }}][nomor]" value="{{ $index + 1 }}">
                                @if($index === count($langkahs) - 1)
                                <button type="button" class="mt-2 text-red-500 remove-step-button">Hapus</button>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Step and Submit Buttons -->
                        <div class="flex justify-between mt-4">
                            <button type="button" id="add-step-button" class="px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Tambah Langkah</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Simpan Langkah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const resepTabButton = document.querySelector('[data-tab="resep"]');
    const langkahTabButton = document.querySelector('[data-tab="langkah"]');
    const resepTab = document.getElementById('resep-tab');
    const langkahTab = document.getElementById('langkah-tab');
    const stepsContainer = document.getElementById('steps-container');
    const addStepButton = document.getElementById('add-step-button');

    function setActiveTab(tab) {
        if (tab === 'langkah') {
            resepTab.classList.add('hidden');
            langkahTab.classList.remove('hidden');
            langkahTabButton.classList.add('border-blue-500', 'text-blue-500');
            resepTabButton.classList.remove('border-blue-500', 'text-blue-500');
        } else {
            resepTab.classList.remove('hidden');
            langkahTab.classList.add('hidden');
            resepTabButton.classList.add('border-blue-500', 'text-blue-500');
            langkahTabButton.classList.remove('border-blue-500', 'text-blue-500');
        }
    }

    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('active_tab') || 'resep';
    setActiveTab(activeTab);

    resepTabButton.addEventListener('click', function() {
        setActiveTab('resep');
    });

    langkahTabButton.addEventListener('click', function() {
        setActiveTab('langkah');
    });

    $('#bahan').select2();
    const jumlahContainer = document.getElementById('jumlah-container');

    $('#bahan').on('select2:select', function(e) {
        const selectedBahanId = e.params.data.id;
        const selectedBahanText = e.params.data.text;
        if (!document.querySelector(`.jumlah-bahan[data-bahan-id="${selectedBahanId}"]`)) {
            const div = document.createElement('div');
            div.classList.add('mb-4', 'jumlah-bahan');
            div.setAttribute('data-bahan-id', selectedBahanId);
            div.innerHTML = `
                <label for="jumlah_${selectedBahanId}" class="block text-gray-700 text-sm font-medium mb-1">Jumlah ${selectedBahanText}</label>
                <input type="text" name="jumlah[${selectedBahanId}]" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="jumlah_${selectedBahanId}">
            `;
            jumlahContainer.appendChild(div);
        }
    });

    $('#bahan').on('select2:unselect', function(e) {
        const unselectedBahanId = e.params.data.id;
        const jumlahBahanDiv = document.querySelector(`.jumlah-bahan[data-bahan-id="${unselectedBahanId}"]`);
        if (jumlahBahanDiv) {
            jumlahBahanDiv.remove();
        }
    });

    let stepIndex = document.querySelectorAll('.langkah-item').length;

    function updateDeleteButtons() {
        const langkahItems = document.querySelectorAll('.langkah-item');
        langkahItems.forEach((item, index) => {
            const removeButton = item.querySelector('.remove-step-button');
            if (index === 0) {
                // Hilangkan tombol hapus pada langkah 1
                if (removeButton) {
                    removeButton.remove();
                }
            } else {
                // Pastikan langkah lainnya memiliki tombol hapus
                if (!removeButton) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.classList.add('mt-2', 'text-red-500', 'remove-step-button');
                    button.textContent = 'Hapus';
                    item.appendChild(button);
                }
            }
        });
    }

    function updateStepLabels() {
        const langkahItems = document.querySelectorAll('.langkah-item');
        langkahItems.forEach((item, index) => {
            const label = item.querySelector('label');
            const number = index + 1;
            label.textContent = `Langkah ${number}`;
            item.querySelector('input[name$="[nomor]"]').value = number;
        });
    }

    // Event delegation for dynamically added delete buttons
    stepsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-step-button')) {
            const stepItem = event.target.closest('.langkah-item');
            stepItem.remove();
            stepIndex--;
            updateStepLabels();
            updateDeleteButtons();
        }
    });

    addStepButton.addEventListener('click', function() {
        const div = document.createElement('div');
        div.classList.add('mb-4', 'langkah-item');
        div.setAttribute('data-index', stepIndex);
        div.innerHTML = `
            <label for="langkah_${stepIndex}" class="block text-gray-700 text-sm font-medium mb-1">Langkah ${stepIndex + 1}</label>
            <textarea name="langkah[${stepIndex}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm"></textarea>
            <input type="hidden" name="langkah[${stepIndex}][nomor]" value="${stepIndex + 1}">
            <button type="button" class="mt-2 text-red-500 remove-step-button">Hapus</button>
        `;
        stepsContainer.appendChild(div);
        stepIndex++;
        updateStepLabels();
        updateDeleteButtons();
    });

    updateDeleteButtons();

    // Add validation to ensure all steps are filled before submitting
    const langkahForm = document.getElementById('langkahForm');
    langkahForm.addEventListener('submit', function(e) {
        const steps = document.querySelectorAll('.langkah-item textarea');
        let allStepsFilled = true;

        steps.forEach(step => {
            if (step.value.trim() === '') {
                allStepsFilled = false;
            }
        });

        if (!allStepsFilled) {
            e.preventDefault();
            alert('Pastikan semua langkah diisi dengan deskripsi yang sesuai.');
        }
    });
});


</script>


</x-app-layout>
