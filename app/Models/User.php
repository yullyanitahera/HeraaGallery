<?php

namespace App\Models;
use App\Models\foto;
use App\Models\album;
use App\Models\folowers;
use App\Models\likefoto;
use App\Models\komenfoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','nama_lengkap','jenis_kelamin','no_telephone','alamat','bio','status_user','foto_profil','email','password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //relasi ke foto
    public function foto()
    {
        return $this->hasMany(foto::class,'users_id','id');
    }
    //relasi ke album
    public function album()
    {
        return $this->hasMany(album::class,'users_id','id');
    }
    //relasi ke komenfoto
    public function komenfoto()
    {
        return $this->hasMany(komenfoto::class,'users_id','id');
    }
    //relasi ke likefoto
    public function likefoto()
    {
        return $this->hasMany(likefoto::class,'users_id','id');
    }
    //relasi ke Folowers
    public function folowers()
    {
        return $this->hasMany(folowers::class,'users_id','id_folowing');
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setRole($role)
    {
        $this->attributes['role'] = $role;
    }
}
