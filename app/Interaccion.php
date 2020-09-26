<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
    public $timestamps = false;
    protected $table = 'omni_fuxion_interacciones';
    protected $fillable = ['session_id', 'accion', 'producto', 'familia', 'created'];
}
