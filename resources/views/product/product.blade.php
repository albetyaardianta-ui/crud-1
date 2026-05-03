@extends('layoutes.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Produk</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            
            <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
    
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    
    @foreach($products as $product)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
        
        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
        
        <td>
            <img src="{{ asset('image/'.$product->foto) }}" width="50" class="rounded">
        </td>
        <td>
            
            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

            <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection