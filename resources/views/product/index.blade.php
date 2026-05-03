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
                        <th>Aksi</th>
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
                            @if($product->foto)
                                <img src="{{ asset('image/'.$product->foto) }}" width="50" class="rounded">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                Hapus
                            </button>

                            
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Produk</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin akan menghapus data **{{ $product->name }}**?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            
                                            
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus Sekarang</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection