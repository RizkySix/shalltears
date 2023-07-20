<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
       'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function announcement(){
        return $this->hasMany(Announcement::class);
    }
    public function voting(){
        return $this->hasMany(Voting::class);
    }
    public function selling_produks(){
        return $this->hasMany(SellingProduk::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function userDesign(){
        return $this->hasMany(UserDesign::class);
    }

    public function design_point(){
        return $this->hasMany(DesignPoint::class);
    }

    public function keranjang(){
        return $this->hasOne(UserKeranjang::class);
    }
}
