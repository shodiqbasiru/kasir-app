<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{

    public function index()
    {
        $barang = Barang::all();
        return response()->json([
            'status' => 'success',
            'data' => $barang
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'stok_barang' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'category_id' => 'required'
        ]);

        $barang = Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'slug' => Str::slug($request->nama_barang, '-'),
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $request->stok_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'category_id' => $request->category_id
        ]);

        // another way to create data

        // $barang = new Barang();
        // $barang->kode_barang = $request->kode_barang;
        // $barang->nama_barang = $request->nama_barang;
        // $barang->slug = Str::slug($barang->nama_barang, '-');
        // $barang->harga_barang = $request->harga_barang;
        // $barang->stok_barang = $request->stok_barang;
        // $barang->deskripsi_barang = $request->deskripsi_barang;
        // $barang->category_id = $request->category_id;
        // $barang->save();

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ]);
    }


    public function show($id)
    {
        $item = Barang::where('id', $id)->first();

        // $item = Barang::find($id);

        return response()->json($item);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'stok_barang' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'category_id' => 'required'
        ]);

        $barang = Barang::where('id', $id)->update([
            'nama_barang' => $request->nama_barang,
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $request->stok_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'category_id' => $request->category_id

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil diupdate',
            'data' => $barang
        ]);
    }


    public function destroy($id)
    {

        $barang = Barang::where('id', $id)->first();
        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil dihapus',
            'data' => $barang
        ]);
    }
}
