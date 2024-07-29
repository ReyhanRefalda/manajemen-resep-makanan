<x-app-layout>
<div class="container">
    <h1>Buat Resep Baru</h1>
    <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Resep</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" required></textarea>
        </div>
        <div class="form-group">
            <label for="waktu_persiapan">Waktu Persiapan (menit)</label>
            <input type="number" name="waktu_persiapan" class="form-control" id="waktu_persiapan" required>
        </div>
        <div class="form-group">
            <label for="waktu_memasak">Waktu Memasak (menit)</label>
            <input type="number" name="waktu_memasak" class="form-control" id="waktu_memasak" required>
        </div>
        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" class="form-control" id="kategori_id" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <label for="image">Gambar</label>
        <input type="file" name="image" class="form-control" id="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</x-app-layout>
