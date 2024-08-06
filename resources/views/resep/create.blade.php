<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Resep Baru') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Tab Navigation -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-4">
                    <button type="button" class="py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="resep">
                        Resep
                    </button>
                    <button type="button" class="py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="langkah">
                        Langkah
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mt-4">
                <!-- Resep Tab -->
                <div id="resep-tab" class="tab-content">
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

                <!-- Langkah Tab -->
                <div id="langkah-tab" class="tab-content hidden">
                    <form id="langkah-form" action="{{ route('langkah.store') }}" method="POST">
                        @csrf
        
                        <div class="mb-4">
                            <label for="resep_id" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                            <select name="resep_id" id="resep_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('resep_id') border-red-500 @enderror">
                                <option value="" disabled selected>Pilih Resep</option>
                                @foreach ($reseps as $res)
                                    <option value="{{ $res->id }}" data-last-step="{{ $lastSteps[$res->id] }}" {{ old('resep_id') == $res->id ? 'selected' : '' }}>{{ $res->nama }}</option>
                                @endforeach
                            </select>
                            @error('resep_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div id="existing-steps-container" class="mb-4">
                            <!-- Langkah yang sudah ada akan ditampilkan di sini -->
                        </div>
        
                        <div id="steps-container" class="flex flex-col space-y-4">
                            <!-- Langkah baru akan ditambahkan di sini -->
                        </div>
        
                        <div class="flex space-x-4 mt-4">
                            <button type="button" id="add-step" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow-md hover:bg-gray-300 transition duration-300">
                                Tambah Langkah
                            </button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                                Simpan Langkah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tab navigation
            document.querySelectorAll('nav button').forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');
                    
                    document.querySelectorAll('.tab-content').forEach(tabContent => {
                        if (tabContent.id === `${tabId}-tab`) {
                            tabContent.classList.remove('hidden');
                        } else {
                            tabContent.classList.add('hidden');
                        }
                    });

                    document.querySelectorAll('nav button').forEach(btn => {
                        if (btn.getAttribute('data-tab') === tabId) {
                            btn.classList.add('border-blue-500');
                            btn.classList.add('text-blue-600');
                        } else {
                            btn.classList.remove('border-blue-500');
                            btn.classList.remove('text-blue-600');
                        }
                    });
                });
            });

            // JavaScript code for dynamic jumlah bahan inputs and validation
            $('#bahan').select2({
                placeholder: "Pilih Bahan",
                allowClear: true
            });

            let bahanList = {!! json_encode($bahans->toArray()) !!};
            let jumlahValues = {}; // Objek untuk menyimpan nilai jumlah bahan

            function populateJumlahFields(selectedBahan) {
                let jumlahContainer = $('#jumlah-container');
                jumlahContainer.empty(); // Clear existing fields

                selectedBahan.forEach(function(id) {
                    let bahan = bahanList.find(b => b.id == id);
                    if (bahan) {
                        let existingValue = jumlahValues[id] || ''; // Ambil nilai dari objek jika ada
                        jumlahContainer.append(`
                            <div class="mb-2" id="jumlah-${bahan.id}">
                                <label for="jumlah[${bahan.id}]" class="block text-gray-700 text-sm font-medium mb-1">Jumlah untuk ${bahan.nama}</label>
                                <input type="text" name="jumlah[${bahan.id}]" min="1" placeholder="Jumlah untuk ${bahan.nama}" class="form-input w-full border-gray-300 rounded-md shadow-sm" value="${existingValue}">
                            </div>
                        `);
                    }
                });
            }

            // Ambil nilai dari input jika ada
            $('#bahan').on('change', function() {
                let selectedBahan = $(this).val() || [];
                
                // Simpan nilai jumlah bahan saat ini
                $('#jumlah-container input').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    let id = name.match(/\d+/)[0]; // Ambil ID dari nama input
                    jumlahValues[id] = value;
                });

                populateJumlahFields(selectedBahan);
            });

            // Inisialisasi nilai jumlah bahan saat halaman dimuat
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

            // Restore the image input field value after form validation fails
            const imageInput = document.querySelector('input[name="image"]');
            if (imageInput) {
                imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Display the selected image
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
        document.getElementById('resep_id').addEventListener('change', function() {
            updateExistingSteps();
            clearNewSteps();
            addNewStep(true);  // Tambahkan langkah baru secara otomatis saat resep dipilih
        });

        document.getElementById('add-step').addEventListener('click', function() {
            var resepId = document.getElementById('resep_id').value;
            if (!resepId) {
                alert('Pilih resep terlebih dahulu sebelum menambahkan langkah.');
                return;
            }
            addNewStep();
        });

        document.getElementById('langkah-form').addEventListener('submit', function(event) {
            var invalidSteps = validateSteps();

            if (invalidSteps.length > 0) {
                alert('Deskripsi langkah harus diisi.');
                event.preventDefault();  // Prevent form submission
            }
        });

        function updateExistingSteps() {
            var resepId = document.getElementById('resep_id').value;
            var container = document.getElementById('existing-steps-container');

            container.innerHTML = ''; // Clear existing steps

            if (resepId) {
                var selectedResep = @json($reseps).find(res => res.id == resepId);

                if (selectedResep && selectedResep.langkah.length > 0) {
                    selectedResep.langkah.forEach(function(step) {
                        var stepElement = document.createElement('div');
                        stepElement.classList.add('step-group', 'simplified-step');
                        stepElement.innerHTML = `
                            <label class="block text-gray-700 text-sm font-medium mb-1">Langkah ${step.nomor}</label>
                            <div class="flex flex-col space-y-2">
                                <input type="number" value="${step.nomor}" class="form-input w-full border-gray-300 rounded-md shadow-sm" placeholder="Nomor Langkah" readonly>
                                <textarea class="form-textarea w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi Langkah" rows="3" readonly>${step.deskripsi}</textarea>
                            </div>
                        `;
                        container.appendChild(stepElement);
                    });
                } else {
                    container.innerHTML = '<p class="text-gray-500">Belum ada langkah untuk resep ini.</p>';
                }
            }
        }

        function clearNewSteps() {
            document.getElementById('steps-container').innerHTML = '';
        }

        function addNewStep(isInitial = false) {
            var container = document.getElementById('steps-container');
            var stepCount = container.getElementsByClassName('step-group').length;
            var lastStep = parseInt(document.querySelector('#resep_id option:checked').dataset.lastStep) || 0;
            var newStepNumber = lastStep + stepCount + 1;

            if (isInitial && lastStep == 0) return; // Jangan tambahkan langkah baru otomatis jika belum ada langkah sebelumnya

            var newStep = document.createElement('div');
            newStep.classList.add('step-group');
            newStep.innerHTML = `
                <label class="block text-gray-700 text-sm font-medium mb-1">Langkah ${newStepNumber}</label>
                <div class="flex flex-col space-y-2">
                    <input type="number" name="steps[${stepCount}][nomor]" value="${newStepNumber}" class="form-input w-full border-gray-300 rounded-md shadow-sm" placeholder="Nomor Langkah" readonly>
                    <textarea name="steps[${stepCount}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi Langkah" rows="3"></textarea>
                </div>
            `;
            container.appendChild(newStep);

            // Simplify existing steps
            var existingSteps = document.querySelectorAll('#existing-steps-container .step-group');
            existingSteps.forEach(step => step.classList.add('simplified-step'));
        }

        function validateSteps() {
            var invalidSteps = [];
            var steps = document.querySelectorAll('textarea[name^="steps"]');

            steps.forEach(function(step) {
                if (step.value.trim() === '') {
                    invalidSteps.push(step);
                }
            });

            return invalidSteps;
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('resep_id').value) {
                updateExistingSteps();
                addNewStep(true);  // Tambahkan langkah baru secara otomatis saat halaman dimuat
            }
        });
    </script>
</x-app-layout>
