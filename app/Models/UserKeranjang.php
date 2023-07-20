<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKeranjang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cutting(){
        return $this->belongsTo(CuttingProduk::class , 'cutting_produk_id');
    }

    public function selling_produks()
    {
        return $this->belongsToMany(SellingProduk::class , 'keranjang_produks' , 'keranjang_id' , 'selling_produks_id')
        ->withTimestamps();
    }
}
