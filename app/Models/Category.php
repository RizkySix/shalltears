<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function announcement(){
        return $this->hasMany(Announcement::class);
    }
    public function voting(){
        return $this->hasMany(Voting::class);
    }
    public function selling_produks(){
        return $this->hasMany(SellingProduk::class);
    }
    public function cutting_produk(){
        return $this->hasMany(CuttingProduk::class);
    }


}
