<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
      'is_admin' => 'boolean'
    ];


    public function profession() //metodo profession en singular //id_profession //si este es el id // return $this->belongsTo(Profession::class, 'id_profession');
    {
        return $this->belongsTo(Profession::class); // Un usuario pertenece a una profesion
    }

    public function isAdmin()
    {
        //return $this->email === 'joseluishube@gmail.com';
        return $this->isAdmin;
    }
}
