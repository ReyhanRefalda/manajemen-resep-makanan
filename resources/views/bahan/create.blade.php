<x-app-layout>
<div class="container">
    <h1>Tambah Bahan</h1>

    <form action="{{ route('bahan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Bahan</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
</x-app-layout>
