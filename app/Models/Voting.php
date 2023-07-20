<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_expired'
     ];

    public function getRouteKeyName()
    {
       return 'slug_id';
    }

    public function announcement(){
        return $this->belongsTo(Announcement::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function partisipanVoting(){
        return $this->hasMany(PartisipanVoting::class);
    }
}
