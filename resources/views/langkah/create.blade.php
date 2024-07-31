<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Langkah Baru untuk Resep') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <form action="{{ route('langkah.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="resep_id" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                    <select name="resep_id" id="resep_id" class="form-select w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($resep as $res)
                            <option value="{{ $res->id }}">{{ $res->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="steps-container">
                    <div class="step-group mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Langkah 1</label>
                        <div class="mb-2">
                            <input type="number" name="steps[0][nomor]" class="form-input w-full border-gray-300 rounded-md shadow-sm" placeholder="Nomor Langkah" >
                        </div>
                        <div class="mb-4">
                            <textarea name="steps[0][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi Langkah" rows="3" ></textarea>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-step" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow-md hover:bg-gray-300 transition duration-300">
                    Tambah Langkah
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Simpan Langkah
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-step').addEventListener('click', function() {
            var container = document.getElementById('steps-container');
            var stepCount = container.getElementsByClassName('step-group').length;
            var newStep = document.createElement('div');
            newStep.classList.add('step-group', 'mb-4');
            newStep.innerHTML = `
                <label class="block text-gray-700 text-sm font-medium mb-1">Langkah ${stepCount + 1}</label>
                <div class="mb-2">
                    <input type="number" name="steps[${stepCount}][nomor]" class="form-input w-full border-gray-300 rounded-md shadow-sm" placeholder="Nomor Langkah" >
                </div>
                <div class="mb-4">
                    <textarea name="steps[${stepCount}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi Langkah" rows="3" ></textarea>
                </div>
            `;
            container.appendChild(newStep);
        });
    </script>
</x-app-layout>
