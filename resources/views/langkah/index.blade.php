<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Langkah') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Langkah-langkah Resep</h3>
                <a href="{{ route('langkah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Tambah Langkah
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($resep->isEmpty())
                <p class="text-gray-500">Belum ada langkah yang ditambahkan.</p>
            @else
                <form action="{{ route('langkah.massdestroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resep</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Langkah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($resep as $index => $res)
                                @foreach ($res->langkah as $step)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <input type="checkbox" name="ids[]" value="{{ $step->id }}" class="form-checkbox">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $res->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $step->nomor }}. {{ $step->deskripsi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                           
                                            <a href="{{ route('langkah.edit', $step->id) }}" class="text-green-600 hover:text-green-900 ml-4">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition duration-300" onclick="return confirm('Yakin ingin menghapus resep ini?')">
                            Hapus Terpilih
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</x-app-layout>
