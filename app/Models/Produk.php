<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks'; 

    // Pastikan kolom ini diizinkan untuk diisi
    protected $fillable = ['nama', 'kategori_id', 'harga_jual', 'harga_beli', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}