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
                        <button type="button" class="tab-button py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="resep">
                            Resep
                        </button>
                        <button type="button" class="tab-button py-2 px-4 text-gray-700 font-semibold border-b-2 border-transparent hover:border-gray-300 focus:outline-none" data-tab="langkah" id="langkah-tab-button" disabled>
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
                                <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama
                                    Resep</label>
                                <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="nama" value="{{ old('nama') }}">
                                @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
                                <textarea name="deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" id="deskripsi">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pilih Bahan -->
                            <div class="mb-4">
                                <label for="bahan" class="block text-gray-700 text-sm font-medium mb-1">Pilih
                                    Bahan</label>
                                <select name="bahan[]" id="bahan" multiple="multiple" class="form-multiselect w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach ($bahans as $bahan)
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
                                <label for="waktu_persiapan" class="block text-gray-700 text-sm font-medium mb-1">Waktu
                                    Persiapan</label>
                                <input type="text" name="waktu_persiapan" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_persiapan') border-red-500 @enderror" id="waktu_persiapan" value="{{ old('waktu_persiapan') }}">
                                @error('waktu_persiapan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="waktu_memasak" class="block text-gray-700 text-sm font-medium mb-1">Waktu
                                    Memasak</label>
                                <input type="text" name="waktu_memasak" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('waktu_memasak') border-red-500 @enderror" id="waktu_memasak" value="{{ old('waktu_memasak') }}">
                                @error('waktu_memasak')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kategori_id" class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
                                <select name="kategori_id" id="kategori_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('kategori_id') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
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
                                    @foreach ($pembuat as $p)
                                    <option value="{{ $p->id }}" {{ old('pembuat_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}
                                    </option>
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
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Next</button>
                            </div>
                        </form>
                    </div>
                    <!-- Langkah Tab -->
                    <div id="langkah-tab" class="tab-content hidden">
                        <form id="langkahForm" action="{{ route('langkah.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="resep_id" id="resep_id">
                            <div class="mb-4">
                                <label for="resep_id_display" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                                <input type="text" id="resep_id_display" class="form-input w-full border-gray-300 rounded-md shadow-sm" disabled>
                            </div>

                            <div id="steps-container" class="flex flex-col space-y-4">
                                <!-- Steps will be dynamically added here -->
                            </div>

                            <div class="flex space-x-2">
                                <button type="button" id="add-step" class="px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Tambah Langkah</button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Simpan Langkah</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const langkahTabButton = document.getElementById('langkah-tab-button');
                const langkahForm = document.getElementById('langkahForm');
                const stepsContainer = document.getElementById('steps-container');
                const resepIdInput = document.getElementById('resep_id');
                const resepIdDisplay = document.getElementById('resep_id_display');
                const bahanSelect = $('#bahan');
                const jumlahContainer = document.getElementById('jumlah-container');

                let jumlahInputs = {}; // To store the quantities

                // Handle tab switching
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const tabId = this.dataset.tab;
                        document.querySelectorAll('.tab-content').forEach(content => {
                            content.classList.add('hidden');
                        });
                        document.getElementById(`${tabId}-tab`).classList.remove('hidden');
                    });
                });

                $('#resepForm').on('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('resep.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                // Tampilkan alert dengan pesan dari server
                                alert(response.message);

                                // Aktivasi tab langkah dan update field resep_id
                                langkahTabButton.disabled = false;
                                resepIdInput.value = response.resep.id;
                                resepIdDisplay.value = response.resep.nama;

                                // Alihkan ke tab langkah
                                document.querySelector('[data-tab="langkah"]').click();
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $('.text-red-500').remove(); // Remove previous errors

                            $.each(errors, function(key, messages) {
                                var input = $('#' + key);
                                input.addClass('border-red-500');
                                input.after('<p class="text-red-500 text-xs mt-1">' +
                                    messages[0] + '</p>');
                            });
                        }
                    });
                });

                // Handle adding steps dynamically
                document.getElementById('add-step').addEventListener('click', function() {
                    const stepNumber = stepsContainer.children.length + 1;

                    // Remove the delete button from the previous last step, if any
                    if (stepsContainer.children.length > 0) {
                        const previousStep = stepsContainer.lastElementChild;
                        const deleteButton = previousStep.querySelector('.delete-step');
                        if (deleteButton) {
                            deleteButton.remove();
                        }
                    }

                    const stepHtml = `
            <div class="step-item" id="step-${stepNumber}">
                <label for="langkah_${stepNumber}_deskripsi" class="block text-gray-700 text-sm font-medium mb-1">Langkah ${stepNumber}</label>
                <textarea name="langkah[${stepNumber}][deskripsi]" id="langkah_${stepNumber}_deskripsi" class="form-textarea w-full border-gray-300 rounded-md shadow-sm"></textarea>
                <input type="hidden" name="langkah[${stepNumber}][nomor]" value="${stepNumber}">
                ${stepNumber > 1 ? `<button type="button" class="delete-step px-2 py-1 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 mt-2">Hapus</button>` : ''}
            </div>
        `;
                    stepsContainer.insertAdjacentHTML('beforeend', stepHtml);

                    // Add event listener to the delete button if it's available
                    if (stepNumber > 1) {
                        document.querySelector(`#step-${stepNumber} .delete-step`).addEventListener('click', function() {
                            const stepItem = this.closest('.step-item');
                            stepItem.remove();

                            // Reassign step numbers and check if we need to add a delete button to the new last step
                            reassignStepNumbers();
                        });
                    }
                });

                // Function to reassign step numbers after deletion
                function reassignStepNumbers() {
                    const steps = document.querySelectorAll('.step-item');
                    steps.forEach((step, index) => {
                        step.id = `step-${index + 1}`;
                        step.querySelector('label').textContent = `Langkah ${index + 1}`;
                        step.querySelector('textarea').name = `langkah[${index + 1}][deskripsi]`;
                        step.querySelector('textarea').id = `langkah_${index + 1}_deskripsi`;
                        step.querySelector('input[type="hidden"]').value = index + 1;
                    });

                    // Add delete button to the last step if there are more than one step
                    if (steps.length > 1) {
                        const lastStep = steps[steps.length - 1];
                        if (!lastStep.querySelector('.delete-step')) {
                            const deleteButtonHtml = `
                    <button type="button" class="delete-step px-2 py-1 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 mt-2">Hapus</button>
                `;
                            lastStep.insertAdjacentHTML('beforeend', deleteButtonHtml);

                            lastStep.querySelector('.delete-step').addEventListener('click', function() {
                                const stepItem = this.closest('.step-item');
                                stepItem.remove();
                                reassignStepNumbers();
                            });
                        }
                    }
                }

                // Initialize select2 for multiple selection and handle dynamic quantity inputs
                bahanSelect.select2().on('select2:select select2:unselect', function() {
                    jumlahContainer.innerHTML = '';
                    const selectedBahan = bahanSelect.val();

                    selectedBahan.forEach((id) => {
                        const bahanName = bahanSelect.find(`option[value="${id}"]`).text();
                        const jumlahValue = jumlahInputs[id] || ''; // Use the stored value if available

                        const jumlahHtml = `
                <div class="mb-4">
                    <label for="jumlah_${id}" class="block text-gray-700 text-sm font-medium mb-1">Jumlah ${bahanName}</label>
                    <input type="text" name="jumlah[${id}]" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="jumlah_${id}" value="${jumlahValue}">
                </div>
            `;
                        jumlahContainer.insertAdjacentHTML('beforeend', jumlahHtml);

                        // Add event listener to store input value on change
                        document.getElementById(`jumlah_${id}`).addEventListener('input', function() {
                            jumlahInputs[id] = this.value;
                        });
                    });
                });

                // Add a step by default on tab switch
                langkahTabButton.addEventListener('click', function() {
                    if (stepsContainer.children.length === 0) {
                        document.getElementById('add-step').click();
                    }
                });

                var resepIndexUrl = "{{ route('resep.index') }}";
                // Handle langkah form submission
                langkahForm.addEventListener('submit', function(e) {
                    // Check if all step descriptions are filled
                    let allStepsFilled = true;
                    document.querySelectorAll('.step-item textarea').forEach(textarea => {
                        if (!textarea.value.trim()) {
                            allStepsFilled = false;
                        }
                    });

                    if (!allStepsFilled) {
                        e.preventDefault();
                        alert('Pastikan semua langkah terisi.');
                        return;
                    }

                    const formData = new FormData(langkahForm);
                    $.ajax({
                        url: "{{ route('langkah.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alert('Langkah berhasil disimpan!');
                            window.location.href = resepIndexUrl;
                        },
                        error: function(xhr) {
                            // Clear previous error messages
                            $('.text-red-500').remove();

                            // Parse error response
                            const errors = JSON.parse(xhr.responseText).errors;

                            // Display error messages for each field
                            for (const [field, messages] of Object.entries(errors)) {
                                // Find the input field related to the error
                                const input = document.querySelector(`[name="${field}"]`);

                                if (input) {
                                    // Create a new error message element
                                    const errorElement = document.createElement('p');
                                    errorElement.className = 'text-red-500 text-xs mt-1';
                                    errorElement.textContent = messages.join(', ');

                                    // Insert error message after the input field
                                    input.insertAdjacentElement('afterend', errorElement);
                                }
                            }
                        }
                    });
                });
            });
        </script>

    </x-app-layout>