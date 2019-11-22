<?php

namespace App\Http\Controllers;

use App\Client;
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
        return Client::find($id);
    }

    public function store(Request $request)
    {
        $client = Client::create($request->all());
        return response()->json($client, 201);
    }


}
