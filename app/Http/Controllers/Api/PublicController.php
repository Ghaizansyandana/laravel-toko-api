<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    // Daftar semua produk, dengan pagination
    public function produk()
    {
        try {
            $produk = DB::table('produk')
                ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                ->select(
                    'produk.id_barang', 'produk.nama_barang', 'produk.harga_barang',
                    'produk.stok', 'produk.deskripsi', 'kategori.nama_kategori'
                )
                ->paginate(10);

            return response()->json([
                'status'  => true,
                'message' => 'Data produk berhasil diambil.',
                'data'    => $produk,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Detail satu produk
    public function detailProduk($id)
    {
        try {
            $produk = DB::table('produk')
                ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                ->select('produk.*', 'kategori.nama_kategori')
                ->where('produk.id_barang', $id)
                ->first();

            if (! $produk) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            return response()->json(['status' => true, 'data' => $produk]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Semua kategori
    public function kategori()
    {
        try {
            $kategori = DB::table('kategori')->get();
            return response()->json(['status' => true, 'data' => $kategori]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Produk berdasarkan kategori tertentu
    public function produkByKategori($id)
    {
        try {
            $produk = DB::table('produk')
                ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                ->where('kategori.id_kategori', $id)
                ->select('produk.*', 'kategori.nama_kategori')
                ->paginate(10);

            return response()->json(['status' => true, 'data' => $produk]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Pencarian produk berdasarkan nama
    public function search(Request $request)
    {
        try {
            $produk = DB::table('produk')
                ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                ->where('produk.nama_barang', 'like', '%' . $request->keyword . '%')
                ->select('produk.*', 'kategori.nama_kategori')
                ->paginate(10);

            return response()->json(['status' => true, 'data' => $produk]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
