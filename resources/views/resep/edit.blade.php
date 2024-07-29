<x-app-layout>
<div class="container">
    <h1>Edit Resep</h1>
    <form action="{{ route('resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Resep</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $resep->nama) }}" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" required>{{ old('deskripsi', $resep->deskripsi) }}</textarea>
        </div>
        <div class="form-group">
            <label for="waktu_persiapan">Waktu Persiapan (menit)</label>
            <input type="number" name="waktu_persiapan" class="form-control" id="waktu_persiapan" value="{{ old('waktu_persiapan', $resep->waktu_persiapan) }}" required>
        </div>
        <div class="form-group">
            <label for="waktu_memasak">Waktu Memasak (menit)</label>
            <input type="number" name="waktu_memasak" class="form-control" id="waktu_memasak" value="{{ old('waktu_memasak', $resep->waktu_memasak) }}" required>
        </div>
        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" class="form-control" id="kategori_id" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $kategori->id == $resep->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="image">Gambar</label>
            @if($resep->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}" style="width: 150px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" id="image">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</x-app-layout>
