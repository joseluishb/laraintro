<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //

    protected $fillable = ['title'];


    public function users()//metodo en plural
    {
        return $this->hasMany(User::class); // una profesion tiene muchos usuarios
    }
    
}
