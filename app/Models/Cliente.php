<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre', 'apellidos']; // Campos permitidos para asignación masiva

    public function garantias()
    {
        return $this->hasMany(Garantia::class, 'cliente_id'); // Relación: Un cliente tiene muchas garantías
    }

}
