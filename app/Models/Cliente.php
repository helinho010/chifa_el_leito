<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $primaryKey = 'nit';
    public $incrementing = false;
    const CREATED_AT = 'fec_cre_cliente';
    const UPDATED_AT = 'fec_act_cliente'; 
}
