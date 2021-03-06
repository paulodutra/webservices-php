<?php

namespace App\Http\Controllers;

use App\Address;
use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function index($clientId)
    {
        //verifica se o cliente existe
        $client = Client::find($clientId);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        //Não precisa serializar porque o lumen por padrão já retorna em json
        return responseHelper()
                ->make(Address::where('client_id',$clientId)->get());
    }

    public function show($id, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        $address = Address::find($id);

        if (!$address) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Endereço não existe");
        }

        $result = Address::where('client_id', $clientId)->where('id', $id)->get()->first();
        return responseHelper()->make($result);
    }

    public function store(Request $request, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        //valida os dados e caso de erro retorna um 422 com a mensagem
        $this->validate($request, [
            'address'  => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required'
        ]);

        $address = $client->addresses()->create($request->all());
        return responseHelper()->make($address, 201);
    }

    public function update(Request $request, $id, $clientId)
    {

        $client = Client::find($clientId);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        $address = Address::find($id);

        if (!$address) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Endereço não existe");
        }

         //valida os dados e caso de erro retorna um 422 com a mensagem
         $this->validate($request, [
            'address'  => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required'
        ]);

        $result = Address::where('client_id', $clientId)->where('id', $id)->get()->first();

        if (!$result) {
            throw new ModelNotFoundException("Endereço não existe");
        }

        $result->fill($request->all());
        $result->save();
        return responseHelper()->make($result, 200);//ou retornar vazio e o status: 204

    }


    public function destroy($id, $clientId)
    {
        $client = Client::find($clientId);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        $address = Address::find($id);

        if (!$address) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Endereço não existe");
        }

        $result = Address::where('client_id', $clientId)->where('id', $id)->get()->first();

        if (!$result) {
            throw new ModelNotFoundException("Endereço não existe");
        }


        $result->delete();
        return responseHelper()->make("", 204);

    }


}
