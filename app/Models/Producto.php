<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    const CREATED_AT = 'fecha_creacion_plato';
    const UPDATED_AT = 'fecha_actualizacion_plato';    
    protected $table = 'producto';
    protected $primaryKey = 'id_codigo_producto';
    public $incrementing = false;
    protected $keyType = 'string';
}
