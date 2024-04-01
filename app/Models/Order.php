<?php

namespace App\Models;

use App\Models\DetailOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'kode_order',
        'id_meja',
        'tanggal',
        'id_user',
        'keterangan',
        'total',
        'status',
    ];

    public function detail() {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }

    public function meja() {
        return $this->belongsTo(Meja::class, 'id_meja');
    }
}
