<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-[#FB773C] text-white fixed h-full">
            @include('layouts.navigation')
        </div>

        <!-- Page Content -->
        <div class="flex-1 p-10 ml-64">
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Select2 pada elemen dropdown bahan
            $('#bahan').select2({
                placeholder: "Pilih Bahan",
                allowClear: true
            });

            const bahanSelect = document.getElementById('bahan');
            const jumlahContainer = document.getElementById('jumlah-container');

            // Tambahkan event listener untuk perubahan pada dropdown bahan
            bahanSelect.addEventListener('change', function() {
                // Hapus semua input jumlah bahan yang ada
                jumlahContainer.innerHTML = '';

                // Tambahkan input jumlah bahan berdasarkan bahan yang dipilih
                const selectedOptions = Array.from(this.selectedOptions);
                selectedOptions.forEach(option => {
                    const jumlahField = document.createElement('div');
                    jumlahField.classList.add('mb-4');
                    jumlahField.innerHTML = `
                        <label for="jumlah_${option.value}" class="block text-gray-700 text-sm font-medium mb-1">Jumlah untuk ${option.text}</label>
                        <input type="number" name="jumlah[${option.value}]" class="form-input w-full border-gray-300 rounded-md shadow-sm" id="jumlah_${option.value}" placeholder="Masukkan jumlah untuk ${option.text}">
                    `;
                    jumlahContainer.appendChild(jumlahField);
                });
            });
        });
    </script>
</body>
</html>
