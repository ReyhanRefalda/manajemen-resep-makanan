<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pembuat') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        

        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto p-6">
            <form action="{{ route('pembuat.update', $pembuat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-medium mb-1">Nama Pembuat</label>
                    <input type="text" name="nama" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="nama" value="{{ old('nama', $pembuat->nama) }}" >
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email Pembuat</label>
                    <input type="text" name="email" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="email" value="{{ old('email', $pembuat->email) }}" >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
