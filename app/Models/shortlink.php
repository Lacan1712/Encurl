<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shortlink extends Model
{
    protected $table = 'shortlink'; //Definindo o nome da minha tabela
    protected $primarykey = 'id';   //Definindo chave primária

    public $timestamp = false;      //Não usaremos timestamp automático, o códiga já busca no servidor
    use HasFactory;
}
