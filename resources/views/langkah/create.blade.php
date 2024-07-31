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

            <form action="{{ route('langkah.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="resep_id" class="block text-gray-700 text-sm font-medium mb-1">Resep</label>
                    <select name="resep_id" id="resep_id" class="form-select w-full border-gray-300 rounded-md shadow-sm @error('resep_id') border-red-500 @enderror">
                        @foreach ($resep as $res)
                            <option value="{{ $res->id }}" {{ old('resep_id') == $res->id ? 'selected' : '' }}>{{ $res->nama }}</option>
                        @endforeach
                    </select>
                    @error('resep_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div id="steps-container" class="flex flex-col space-y-4">
                    @foreach (old('steps', [['nomor' => '', 'deskripsi' => '']]) as $index => $step)
                        <div class="step-group">
                            <label class="block text-gray-700 text-sm font-medium mb-1">Langkah</label>
                            <div class="flex flex-col space-y-2">
                                <input type="number" name="steps[{{ $index }}][nomor]" value="{{ $step['nomor'] }}" class="form-input w-full border-gray-300 rounded-md shadow-sm @error('steps.'.$index.'.nomor') border-red-500 @enderror" placeholder="Nomor Langkah">
                                @error('steps.'.$index.'.nomor')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                                <textarea name="steps[{{ $index }}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm @error('steps.'.$index.'.deskripsi') border-red-500 @enderror" placeholder="Deskripsi Langkah" rows="3">{{ $step['deskripsi'] }}</textarea>
                                @error('steps.'.$index.'.deskripsi')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
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

    <script>
        document.getElementById('add-step').addEventListener('click', function() {
            var container = document.getElementById('steps-container');
            var stepCount = container.getElementsByClassName('step-group').length;
            var newStep = document.createElement('div');
            newStep.classList.add('step-group');
            newStep.innerHTML = `
                <label class="block text-gray-700 text-sm font-medium mb-1">Langkah ${stepCount + 1}</label>
                <div class="flex flex-col space-y-2">
                    <input type="number" name="steps[${stepCount}][nomor]" class="form-input w-full border-gray-300 rounded-md shadow-sm" placeholder="Nomor Langkah">
                    <textarea name="steps[${stepCount}][deskripsi]" class="form-textarea w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi Langkah" rows="3"></textarea>
                </div>
            `;
            container.appendChild(newStep);
        });
    </script>
</x-app-layout>
