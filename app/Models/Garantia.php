<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $fillable = ['codigo_garantia', 'ticket', 'cliente_id', 'estado'];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

}
