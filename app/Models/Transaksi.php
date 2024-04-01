<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'kode_transaksi',
        'id_user',
        'id_order',
        'tanggal',
        'total',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
