<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Masakan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';

    protected $fillable = [
        'id_order',
        'id_masakan',
        'keterangan',
        'qty',
        'subtotal',
        'status',
    ];

    public function masakan() {
        return $this->belongsTo(Masakan::class, 'id_masakan');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
