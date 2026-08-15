<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Exception;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        try {
            // eager load relasi kategori, biar tidak query berkali-kali (N+1 problem)
            $produk = Produk::with('kategori')->latest()->get();

            return response()->json([
                'status'  => true,
                'message' => 'Data produk berhasil diambil.',
                'data'    => $produk,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_barang'  => 'required|unique:produks,nama_barang',
                'harga_barang' => 'required|integer',
                'deskripsi'    => 'required',
                'stok'         => 'required|integer',
                'id_kategori'  => 'required|exists:kategori,id_kategori',
            ]);

            $produk = Produk::create($request->only([
                'nama_barang', 'harga_barang', 'deskripsi', 'stok', 'id_kategori',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil ditambahkan.',
                'data'    => $produk->load('kategori'),
            ], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $produk = Produk::with('kategori')->find($id);

            if (! $produk) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            return response()->json(['status' => true, 'data' => $produk]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::find($id);
            if (! $produk) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            $request->validate([
                'nama_barang'  => 'required|unique:produks,nama_barang,' . $id . ',id_barang',
                'harga_barang' => 'required|integer',
                'deskripsi'    => 'required',
                'stok'         => 'required|integer',
                'id_kategori'  => 'required|exists:kategoris,id_kategori',
            ]);

            $produk->update($request->only([
                'nama_barang', 'harga_barang', 'deskripsi', 'stok', 'id_kategori',
            ]));

            return response()->json([
                'status'  => true,
                'message' => 'Produk berhasil diperbarui.',
                'data'    => $produk->load('kategori'),
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::find($id);
            if (! $produk) {
                return response()->json(['status' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            $produk->delete();

            return response()->json(['status' => true, 'message' => 'Produk berhasil dihapus.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
