<x-app-layout>
<div class="container">
    <h1>{{ $resep->nama }}</h1>
    <img src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}" class="img-fluid">
    <p>{{ $resep->deskripsi }}</p>
    <p><strong>Kategori:</strong> {{ $resep->kategori->nama }}</p>
    <p><strong>Pembuat:</strong> {{ $resep->pembuat->nama }}</p>

    <h3>Bahan-bahan</h3>
    <ul>
        @forelse($resep->bahans as $bahan) <!-- Ubah 'bahan' menjadi 'bahans' -->
        <li>{{ $bahan->nama }} : {{ $bahan->pivot->jumlah }}</li>
        @empty
        <li>Tidak ada bahan.</li>
        @endforelse
    </ul>

    <h3>Langkah-langkah</h3>
    <ul>
        @forelse($resep->langkah as $langkah)
        <li><strong>Langkah {{ $langkah->nomor }}:</strong> {{ $langkah->deskripsi }}</li>
        @empty
        <li>Tidak ada langkah.</li>
        @endforelse
    </ul>

    <a href="{{ route('resep.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Resep</a>
</div>
</x-app-layout>
