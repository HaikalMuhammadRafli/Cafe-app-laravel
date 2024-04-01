<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Masakan extends Model
{
    use HasFactory;

    protected $table = 'masakans';

    protected $fillable = [
        'nama_masakan',
        'harga',
        'tipe',
        'stok',
        'status',
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id_masakan');
    }
}
