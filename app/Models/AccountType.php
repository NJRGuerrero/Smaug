<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    /**
     * Nombre de la tabla
     * Se declara para evitar conflicto de esquemas otros sistemas Laravel en el mismo ambiente
     * @var  string
     */
    protected $table = 'smaug_db.account_types';
}
