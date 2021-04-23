<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class firmaElectronicaModel extends Model
{
    
    protected $table ="firmaelectronica";
    protected $fillable = ['certificado','clave_privada','id_usuario', 'serial', 'captura','cert','llave','password','created_at','updated_at'];

    //
}
