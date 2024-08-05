<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Langkah Baru untuk Resep') }}
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

    <style>
        .simplified-step {
            background-color: #f7f7f7;
            padding: 8px;
            border-left: 4px solid #ccc;
            margin-bottom: 6px;
            font-size: 12px;
        }

        .simplified-step label {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .simplified-step .flex {
            display: flex;
            align-items: center;
        }

        .simplified-step input,
        .simplified-step textarea {
            border: none;
            background: none;
            resize: none;
            padding: 0;
            font-size: 12px;
            line-height: 1.2;
        }

        .simplified-step textarea {
            height: auto;
        }
    </style>

    <script>
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
