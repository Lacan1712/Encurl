<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shortlink extends Model
{
    use HasFactory;

    protected $table = 'shortlink';
    protected $primarykey = 'Id';

    /**Para uso futuro
     *$fillable para indicar quais campos podem ser preenchidos em massa
     *$guarded para indicar quais campos NÃO podem ser preenchidos em massa
    */
    protected $fillable = ['id'];
}
