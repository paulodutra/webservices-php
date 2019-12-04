<?php

namespace App\Soap;

use App\Client;
use App\Types\ClientType;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;
use Illuminate\Contracts\Support\Arrayable;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
//use Illuminate\Http\Request;

class ClientSoapController
{

    /**
     * listAll: Responsável por listar todos os clientes e retornar os dados em XML
     * @return string
     */
    public function listAll()
    {
        return $this->getXml(Client::all());
    }

    /**
     *
     * @return string
     */
    public function create($type)
    {


        /*$data = new ClientType();
        $data->name = $type->name;
        $data->email = $type->email;
        $data->phone = $type->phone;

        $data = (array) $data;*/

       /* $data['name'] = $type['name'];
        $data['email'] = $type['email'];
        $data['phone'] = $type['phone'];*/

        $data = [
            'name' =>  $type['name'],
            'email' => $type['email'],
            'telefone' => $type['phone']
        ];

        $client = Client::create($data);
        print_r($client);
        return $this->getXml($client);
    }


     /**
     * getXml: Método responsável por receber os dados no formato Arrayable e retorna em XML
     * @param $data
     * @return $xmlWriter->toString($config);
     */
    protected function getXml($data)
    {

        if ($data instanceof Arrayable) {

            $data = $data->toArray();
        }

        //configura o xml com um node pai maximo e o segundo parametro diz que permite alteração
        $config = new Config(['result' => $data], true);
        //Cria o xml e transforma o array em XML
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }




}
