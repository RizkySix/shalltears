<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partisipan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function announcement(){
        return $this->belongsTo(Announcement::class);
    }
}
