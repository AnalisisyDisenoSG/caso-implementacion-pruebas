<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    /** @use HasFactory<\Database\Factories\CarreraFactory> */
    use HasFactory;

    protected $fillable = ['codCarrera', 'nombre'];
    //protected $guarded = [];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
