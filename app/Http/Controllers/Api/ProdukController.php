<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        try {
            $produk = Produk::with('kategori')->latest()->get();

            return response()->json([
                'status' => true,
                'message' => 'Data Produk Berhasil Diambil',
                'data' => $produk,
            ], 200);
        } catch (exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_barang' => 'required|unique:produks,nama_barang',
                'harga_barang' => 'required|integer',
                'deskripsi' => 'required|',
                'stok' => 'required|integer',
                'id_kategori' => 'required|exists:kategori,id_kategori',
            ]);

            $produk = Produk::create($request->only([
                'nama_barang', 'harga_barang', 'deskripsi', 'stok', 'id_kategori'
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Produk Berhasil Ditambahkan',
                'data' => $produk->load('kategori'),
            ]);
        } catch (exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $request->validate([
                'nama_barang' => 'required|unique:produks,nama_barang',
                'harga_barang' => 'required|integer',
                'deskripsi' => 'required|',
                'stok' => 'required|integer',
                'id_kategori' => 'required|exists:kategori,id_kategori',
            ]);

            $produk = Produk::create($request->only([
                'nama_barang', 'harga_barang', 'deskripsi', 'stok', 'id_kategori'
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Produk Berhasil Ditambahkan',
                'data' => $produk->load('kategori'),
            ]);
        } catch (exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
