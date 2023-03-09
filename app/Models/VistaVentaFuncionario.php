<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaVentaFuncionario extends Model
{
    use HasFactory;
    protected $table = 'detalleventasfuncionario';
    public $incrementing = false;
    public $timestamps = false;
}
