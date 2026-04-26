<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        // Memanggil file produk.blade.php di folder resources/views/produk/
        return view('produk.produk', compact('produk'));
    }

    public function create()
    {
       
        return view('produk.create');
    }

   public function edit($id)
{
    $id = Produk::findOrFail($id); 

    return view('produk.edit', compact('id'));
}
public function update(request $request, string $id)
{
    $request->validate([
            'nama' => 'required|max:45',
            'jenis' => 'required|max:45',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
              'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                   ],
                   [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 45 karakter',
            'jenis.required' => 'jenis wajib diisi',
            'jenis.max' => 'jenis maksimal 45 karakter',
            'foto.max' => 'Foto maksimal 2 MB',
            'foto.mimes' => 'File ekstensi hanya bisa jpg,png,jpeg,gif, svg',
            'foto.image' => 'File harus berbentuk image'
                   ]);
                   $fotoLama = DB::table('produks')->select('foto')->where('id', $id)->get();
                   foreach($fotoLama as $f1){
                    $fotoLama = $f1->foto;
                   }
if(!empty($request->foto)){
    if(empty($fotoLama->foto)) unlink(public_path('image' .$fotoLama->foto));
    $fileName ='foto-' .$request->id.'.' .$request->foto->extension();
    $request->foto->move(public_path('image'), $fileName);
}else{
    $fileName = $fotoLama;
}
DB::table('produks')->where('id', $id)->update([
    'nama' => $request->nama,
    'jenis' =>$request->jenis,
    'harga_jual'=>$request->harga_jual,
    'harga_beli' =>$request->harga_beli,
    'deskripsi' =>$request->deskripsi,
    'foto'=>$fileName,
]);
return redirect()->route('index.index');
}
public function destroy(Produk $id)
{
    $id->delete();
    return redirect()->route('index.index')
    ->with('sucess','Data berhasil di hapus');
}
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:45',
            'jenis' => 'required|max:45',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ],
        [
        'nama.required' => 'Nama wajib diisi',
        'nama.max' => 'Nama maksimal 45 karakter',
        'jenis.required' => 'jenis wajib diisi',
        'jenis.max' => 'jenis maksimal 45 karakter',
        'foto.max' => 'Foto maksimal 2 MB',
        'foto.mimes' => 'File ekstensi hanya bisa jpg,png,jpeg,gif, svg',
        'foto.image' => 'File harus berbentuk image'
        ]);
        if(!empty($request->foto)){
            $fileName = 'foto-' .uniqid().'.'.$request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        }else {
            $fileName = 'nophoto.jpg';
        }

         DB::table('produks')->insert([
        'nama'=>$request->nama,
        'jenis'=>$request->jenis,
        'harga_jual'=>$request->harga_jual,
        'harga_beli'=>$request->harga_beli,
        'deskripsi' => $request->deskripsi,
        'foto'=>$fileName,
         ]);
         return redirect()->route('index.index');
    }
};