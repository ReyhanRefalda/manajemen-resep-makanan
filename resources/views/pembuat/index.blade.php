<x-app-layout>
    <div class="flex justify-between items-center">
        <!-- Input search with icon -->
        <div class="relative flex-1">
            <input type="text" placeholder="Cari Pembuat..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 " />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>
        
        <!-- Dropdown profile -->
        <x-profile-dropdown />
    </div>

    <div class="container mx-auto mt-8 px-4">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
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
                    }, 1000); // 3000ms = 3 seconds
                });
            </script>
        @endif

        <!-- Button Tambah Pembuat -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('pembuat.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                + Tambah Pembuat
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembuat as $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $item->nama }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $item->email }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="{{ route('pembuat.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('pembuat.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
