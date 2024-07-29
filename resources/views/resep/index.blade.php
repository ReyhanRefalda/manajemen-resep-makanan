<x-app-layout>
<div class="container">
    <h1>Daftar Resep</h1>
    <a href="{{ route('resep.create') }}" class="btn btn-primary">Tambah Resep</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Waktu Persiapan</th>
                <th>Waktu Memasak</th>
                <th>Kategori</th>
                <th>Gambar</th> <!-- Tambahkan header untuk kolom image -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resep as $item)
            <?php $no = 1 ?>
                <tr>
                    <td>{{$no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->waktu_persiapan }}</td>
                    <td>{{ $item->waktu_memasak }}</td>
                    <td>{{ $item->kategori->nama }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama }}" style="width: 100px;">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('resep.edit', $item) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('resep.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
