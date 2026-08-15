<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;



    protected $fillable = ['id_pelanggan', 'tanggal'];
		public $timestamps    = false;


    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }


    public function produk()
		{
		    return $this->belongsToMany(
		        Produk::class,
		        'detail_pesanan',
		        'id_pesanan',
		        'id_produk'
		    )->withPivot('jumlah');
		}
}
