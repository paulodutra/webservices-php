<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * fillable: Atributo responsável por informar quais colunas
     * permitem a inserção de dados (MassAssignment)
     */
    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    /**
     * addresses: Método responsável por relacionar o modelo de address suas respectivas tabelas
     * onde um client pode ter 1 ou varios address
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
