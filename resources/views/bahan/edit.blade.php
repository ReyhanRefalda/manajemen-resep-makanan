<x-app-layout>
    <div class="container">
        <h1>Edit Bahan</h1>

        <form action="{{ route('bahan.update', $bahan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama Bahan</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $bahan->nama }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</x-app-layout>
