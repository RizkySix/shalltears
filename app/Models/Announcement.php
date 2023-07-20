<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
     ];

     protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_expired'
     ];

     public function getRouteKeyName()
     {
        return 'slug_id';
     }

     public function user(){
        return $this->belongsTo(User::class);
    }
    public function voting(){
        return $this->hasOne(Voting::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function partisipan(){
        return $this->hasMany(Partisipan::class);
    }

    public function userDesign(){
        return $this->hasMany(UserDesign::class);
    }
}
