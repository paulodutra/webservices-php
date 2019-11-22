<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * fillable: Atributo responsável por informar quais colunas
     * permitem a inserção de dados (MassAssignment)
     */
    protected $fillable = [
        'address',
        'city',
        'state',
        'zipcode'
    ];

    /**
     * client: Método responsável por relacionar a tabela de addresses com Client
     * onde 1 endereço pertence a um client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}

