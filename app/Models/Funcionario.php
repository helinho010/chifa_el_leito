<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    const CREATED_AT = 'fec_cre_funcionario';
    const UPDATED_AT = 'fec_act_funcionario';    
    protected $table = 'funcionario';
    protected $primaryKey = 'id_funcionario';
    
}
