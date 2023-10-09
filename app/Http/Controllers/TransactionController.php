<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetails;

class TransactionController extends Controller
{


    public function index()
    {
        $transaction = Transaction::with('transaction_details.barang')->get();

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ]);
    }


    public function createData(Request $request)
    {

        // Validasi input


        // Buat transaksi baru
        $transaction = new Transaction;
        $transaction->tanggal_transaksi = $request->input('tanggal_transaksi');
        $transaction->total_harga = $request->input('total_harga');

        // Buat nomor transaksi dengan pola "SBS001"
        $lastTransaction = Transaction::orderBy('id', 'desc')->first();
        $transactionNumber = $lastTransaction ? 'SBS' . str_pad($lastTransaction->id + 1, 3, '0', STR_PAD_LEFT) : 'SBS001';

        $transaction->no_transaksi = $transactionNumber;
        // Simpan transaksi ke database
        $transaction->save();

        // Simpan ID transaksi dalam variabel
        $transactionId = $transaction->id;

        // Buat data transaksi detail
        $transactionDetails = $request->input('details'); // Ambil data dari input request

        foreach ($transactionDetails as $detail) {
            $transactionDetail = new TransactionDetails();
            $transactionDetail->transaction_id = $transactionId; // Gunakan ID transaksi
            $transactionDetail->barang_id = $detail['barang_id'];
            $transactionDetail->qty = $detail['qty'];
            $transactionDetail->total_harga = $detail['total_harga'];
            $transactionDetail->save();

            // Kurangi stok barang
            $barang = Barang::find($detail['barang_id']);
            if ($barang) {
                $barang->stok_barang = $barang->stok_barang - $detail['qty'];
                $barang->save();
            }
        }

        return response()->json(['message' => 'Transaction created', 'transaction' => $transaction], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with('transaction_details.barang')->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully',
            'data' => $transaction
        ]);
    }
}
