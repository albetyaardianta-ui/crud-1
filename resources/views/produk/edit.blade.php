@extends('layoutes.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Produk</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $k->id == $produk->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="{{ $produk->harga_jual }}" required>
                </div>

                <div class="mb-3">
                    <label>Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" value="{{ $produk->harga_beli }}" required>
                </div>

                <div class="mb-3">
                    <label>Foto Produk (Kosongkan jika tidak ingin ganti)</label>
                    <input type="file" name="foto" class="form-control">
                    <br>
                    <small>Foto saat ini:</small><br>
                    <img src="{{ asset('image/'.$produk->foto) }}" width="100" class="rounded">
                </div>

                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection