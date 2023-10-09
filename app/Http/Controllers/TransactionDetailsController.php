<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetails;
use Illuminate\Http\Request;

class TransactionDetailsController extends Controller
{
    //

    public function createData(Request $request)
    {

        return $request;
        // $transactionDetails = new TransactionDetails();
        // $transactionDetails->transaction_id = $request->input('transaction_id');
        // $transactionDetails->barang_id = $request->input('barang_id');
        // $transactionDetails->qty = $request->input('qty');
        // $transactionDetails->total_harga = $request->input('total_harga');
        // $transactionDetails->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Transaction details created successfully',
        //     'data' => $transactionDetails
        // ]);
    }
}
