<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $data = Category::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data kategori',
            'data' => $data
        ], 200);
    }


    public function store(Request $request)
    {

        $request->validate([
            'nama_kategori' => 'required|unique:categories|max:255',
        ]);

        $data = new Category();
        $data->nama_kategori = $request->nama_kategori;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil ditambahkan',
            'data' => $data
        ], 200);
    }


    public function show($id)
    {

        $category = Category::find($id);
        $barang = Barang::where('category_id', $id)->get();
        $category->barang = $barang;


        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data kategori',
            'data' => $category
        ], 200);
        // $category = DB::table('categories')
        //     ->select('categories.*', 'barangs.nama_barang', 'barangs.harga_barang', 'barangs.stok_barang')
        //     ->leftJoin('barangs', 'categories.id', '=', 'barangs.categories_id')
        //     ->where('categories.id', $id)
        //     ->first();

    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_kategori' => 'required|unique:categories|max:255',
        ]);

        // $data = Category::find($id);
        // $data->nama_kategori = $request->nama_kategori;
        // $data->save();

        // mass assigment update
        $data = Category::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil diupdate',
            'data' => $data
        ], 200);
    }


    public function destroy($id)
    {
        $data = Category::find($id);
        // dd($data);
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil dihapus',
            'data' => $data
        ], 200);
    }
}
