<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <div class="flex justify-between items-center my-5">
            <!-- Input search with icon -->
            <div class="relative flex-1">
                <input type="text" placeholder="Cari Pembuat..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
            </div>
            
            <!-- Dropdown profile -->
            <x-profile-dropdown />
        </div>
        <div class="flex justify-between items-center mb-6 max-w-4xl">
            <h1 class="text-2xl font-bold">Daftar Pembuat</h1>
        </div>
        <!-- Tabel Pembuat -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                @if (session('success'))
                    <div id="success-alert" class="bg-green-500 text-white p-4 rounded mb-4">
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
                            }, 6000); // 3000ms = 3 seconds
                        });
                    </script>
                @endif
                <div class="flex justify-start mb-4">
                    <a href="{{ route('pembuat.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Tambah Pembuat
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($pembuat as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                    <td class="px-4 py-3 text-sm">{{ $item->nama }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item->email }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('pembuat.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded shadow hover:bg-yellow-600 transition duration-300 text-sm flex items-center">
                                                Edit
                                            </a>
                                            <form action="{{ route('pembuat.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition duration-300 text-sm flex items-center" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
