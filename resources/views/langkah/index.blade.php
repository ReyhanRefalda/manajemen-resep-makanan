<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Langkah-Langkah') }}
            </h2>
        </x-slot>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            @if(session('success'))
                <div id="success-alert" class="bg-green-500 text-white p-4 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        setTimeout(function () {
                            const alert = document.getElementById('success-alert');
                            if (alert) {
                                alert.style.opacity = 0;
                                setTimeout(function () {
                                    alert.style.display = 'none';
                                }, 500); // 500ms to wait until the fade out is complete
                            }
                        }, 6000); // 6000ms = 6 seconds
                    });
                </script>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <!-- Search Form -->
                <form action="{{ route('langkah.index') }}" method="GET" class="flex items-center w-full max-w-md mx-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Langkah ..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" />
                    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <!-- Add an icon or text if needed -->
                    </button>
                </form>
            </div>
            
            @if($resep->isEmpty())
                <p class="text-gray-500 text-center">
                    @if(request('search'))
                        Tidak ada langkah ditemukan untuk pencarian "{{ request('search') }}"
                    @else
                        Tidak ada data langkah yang tersedia.
                    @endif
                </p>
            @else
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resep</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Langkah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($resep as $index => $res)
                            @foreach ($res->langkahs as $step)
                                <tr class="hover:bg-gray-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $res->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $step->nomor }}. {{ Str::limit($step->deskripsi,50) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    
</x-app-layout>