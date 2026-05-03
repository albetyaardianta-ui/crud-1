@extends('layoutes.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Produk</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->nama }}" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Harga Jual</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="mb-3">
                    <label>Harga Beli</label>
                    <input type="number" name="purchase_price" class="form-control"value="{{ old('purchase_price', $product->purchase_price) }}" required>
                </div>

                <div class="mb-3">
                    <label>Foto Produk (Kosongkan jika tidak ingin ganti)</label>
                    <input type="file" name="foto" class="form-control">
                    <br>
                    <small>Foto saat ini:</small><br>
                    <img src="{{ asset('image/'.$product->foto) }}" width="100" class="rounded">
                </div>

                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection