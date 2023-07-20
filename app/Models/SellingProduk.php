<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingProduk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
       return 'slug_id';
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function design_point(){
        return $this->hasOne(DesignPoint::class);
    }

    public function diskon(){
        return $this->belongsTo(Diskon::class);
    }

    public function order(){//new
        return $this->hasMany(Order::class);
    }


    public function cutting_produks()
    {
        return $this->belongsToMany(CuttingProduk::class , 'selling_produks_cutting_produks' , 'selling_produks_id' , 'cutting_produks_id')
        ->withPivot(['stok_produk'])
        ->withTimestamps();
    }
}
