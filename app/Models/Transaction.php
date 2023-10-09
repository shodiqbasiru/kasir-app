<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\TransactionDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }
}
