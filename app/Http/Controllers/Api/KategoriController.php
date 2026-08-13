<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Exception;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        try {
            $kategori = Kategori::lastest()->get();
            return response()->json([
                'status' => true,
                'messae' => 'Data Kategori Berhasil Diambil',
                'data' => $kategori,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required|string|nama_kategori'
            ]);

            $kategori = Kategori::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return response()->json([
                'status' => true,
                'messae' => 'Data Kategori Berhasil Dibuat',
                'data' => $kategori,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update (Request $request, $id)
    {
        try {
            $kategori = Kategori::find($id);
            if (! $kategori) {
                return response()->json([
                    'status' => false,
                    'message' => 'data kategori tidak ada'
                ], 404);

                $request-validate([
                    'name_kategori' => 'required|unique:kategori,nama_kategori,' . $id . 'id_kategori',
                ]);

                $kategori->nama_kategori = $request->nama_kategori;
                $kategori->save();

                return response()->json([
                    'status' => true,
                    'message' => 'data kategori berhasil di edit',
                    'data' => $kategori,
                ], 200);
            } catch (Exception $e) {
                return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function destroy($id)
        {
            try {
                $kategori = Kategori::find($id);
                if (! $kategori) {
                    return response()->json(['status' => false, 'message' => 'data kategori tidak di temukan'], 404);
                }

                $kategori->delete();
                return response()->json(['status' => true, 'message' => 'data kategori berhasil di hapus'], 200);
            } catch (exception $e) {
                return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
            }
        }
    }
}
