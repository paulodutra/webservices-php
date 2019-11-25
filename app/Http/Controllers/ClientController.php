<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        //Não precisa serializar porque o lumen por padrão já retorna em json
        return Client::all();
    }

    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        return $client;
    }

    public function store(Request $request)
    {
        //valida os dados e caso de erro retorna um 422 com a mensagem
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $client = Client::create($request->all());
        return response()->json($client, 201);
    }

    public function update(Request $request, $id)
    {

        $client = Client::find($id);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        //valida os dados e caso de erro retorna um 422 com a mensagem
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        //fill: serve para introduzir um array de dados
        $client->fill($request->all());
        $client->update();
        return response()->json($client, 200);//ou retornar vazio e o status: 204

    }


    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            //classe do lumen especifica para casos de 404, já retorna a resposta com esse status code
            throw new ModelNotFoundException("Cliente não existe");
        }

        $client->delete();
        return response()->json("", 204);

    }


}
