<x-app-layout>
    <div class="container">
        <h1>Daftar Bahan</h1>
        <a href="{{ route('bahan.create') }}" class="btn btn-primary mb-3">Tambah Bahan</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bahans as $bahan)
                <php $no = 1 ?>
                    <tr>
                        <td>{{ $bahan->id }}</td>
                        <td>{{ $bahan->nama }}</td>
                        <td>
                            <a href="{{ route('bahan.edit', $bahan->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('bahan.destroy', $bahan->id) }}" method="POST" style="display:inline;">
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
