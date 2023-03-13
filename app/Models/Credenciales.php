<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credenciales extends Model
{
    use HasFactory;
    const CREATED_AT = 'fecha_creacion_credencial';
    const UPDATED_AT = 'fecha_actualizacion_credencial';    
    protected $table = 'credenciales';
    protected $primaryKey = 'id_credencial';
}
