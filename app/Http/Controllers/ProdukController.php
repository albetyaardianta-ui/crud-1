<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('produk.produk', compact('produk'));
    }

    public function create()
    {
       $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

   public function edit($id)
{
    $produk = Produk::findOrFail($id);
    $kategori = Kategori::all();
    return view('produk.edit', compact('produk', 'kategori'));
}
public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|max:45',
            'kategori_id' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $fileName = $produk->foto;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika bukan nophoto.jpg
            if ($produk->foto && $produk->foto != 'nophoto.jpg' && file_exists(public_path('image/' . $produk->foto))) {
                unlink(public_path('image/' . $produk->foto));
            }
            $fileName = 'foto-' . $id . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        }

        $produk->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'deskripsi' => $request->deskripsi,
            'foto' => $fileName,
        ]);

        return redirect()->route('produk.index');
    }
 public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|max:45',
        'kategori_id' => 'required|exists:kategoris,id',
        'harga_jual' => 'required',
        'harga_beli' => 'required',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    if (!empty($request->foto)) {
        $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
        $request->foto->move(public_path('image'), $fileName);
    } else {
        $fileName = 'nophoto.jpg';
    }

   
    DB::table('produks')->insert([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id, // Gunakan ini
        'harga_jual' => $request->harga_jual,
        'harga_beli' => $request->harga_beli,
        'deskripsi' => $request->deskripsi,
        'foto' => $fileName,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
}

  
  public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Data berhasil dihapus');
    }
};