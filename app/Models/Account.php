<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\AccountType;
use App\Models\Currency;
use App\User;
use Auth;

class Account extends Model
{
    /**
     * Borrado logico
     */
    use SoftDeletes;
    
    /**
     * Nombre de la tabla
     * Se declara para evitar conflicto de esquemas otros sistemas Laravel en el mismo ambiente
     * @var  string
     */
    protected $table = 'smaug_db.accounts';
    
    /**
     * Fechas a convertir a objeto Carbon para su uso
     * created_at y updated_at ya se convierten a Carbon
     * Ej: $model->deleted_at->format('d/m/Y')
     */
    protected $dates = ['deleted_at'];


    
    /*
     * Eventos disparados durante la interacción con la base de datos
     * Crear: creating / created
     * Actualizar: updating / updated
     * Ambos: saving / saved
     */
    public static function boot()
    {
        parent::boot();
        
        // Actualiza el updated_by cada que se modifica el registro
        static::creating(function ($obj) {
            $obj->user()->associate(Auth::user());
            $obj->active = true;
        });
    }

    /* Relaciones */
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    
    public function validationErrors(){
        $messages = [];

        if(is_null($this->name) || $this->name == ''){
            array_push($messages, ['name', 'El Nombre no puede estár vacío']);
        } else if((is_null($this->id) && count(Account::where('name', $this->name)->get()) > 0 ) || 
            (!is_null($this->id) && count(Account::where('name', $this->name)->where('id', '!=', $this->id)->get()) > 1)){
            array_push($messages, ['name', 'Nombre ya existente']);
        }

        if(is_null($this->currency)){
            array_push($messages, ['currencyId', 'Moneda invalida']);
        }

        if(is_null($this->accountType)){
            array_push($messages, ['accountTypeId', 'Tipo de cuenta invalido']);
        }

        if(is_null($this->balance) || !is_numeric($this->balance)){
            array_push($messages, ['balance', 'Balance invalido']);
        }

        if(is_null($this->notes) || $this->notes == ''){
            array_push($messages, ['notes', 'La Descripción no puede estár vacía']);
        }

        return $messages;
    }

    public function isValid(){
        return (count($this->validationErrors()) == 0);
    }

    public function getIsActiveAttribute(){
        return is_null($this->deleted_at);
    }
}
