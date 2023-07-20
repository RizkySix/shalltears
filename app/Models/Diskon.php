<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_mulai',
        'tanggal_selesai',
     ];

    public function selling_produk(){
        return $this->hasMany(SellingProduk::class);
    }

}
