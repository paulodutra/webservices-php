<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Zend\Soap\Client;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group([
    'prefix' => 'api/clients',
    //'namespace' => 'App\Http\Controllers'
], function() use($router) {
    //api/client
    $router->get('', 'ClientController@index');
    $router->get('{id}', 'ClientController@show');
    $router->post('', 'ClientController@store');
    $router->put('{id}', 'ClientController@update');
    $router->delete('{id}', 'ClientController@destroy');

});

$router->group([
    'prefix' => 'api/clients/{client}/addresses',
    //'namespace' => 'App\Http\Controllers'
], function() use($router) {
    //api/clients/id/addresses
    $router->get('', 'AddressController@index');
    $router->get('{id}', 'AddressController@show');
    $router->post('', 'AddressController@store');
    $router->put('{id}', 'AddressController@update');
    $router->delete('{id}', 'AddressController@destroy');

});

//Consumo de um webservice SOAP do TCU via Soap Client com Zend/SOAP
$router->get('tcu', function() {
    $client = new Client('http://contas.tcu.gov.br/debito/CalculoDebito?wsdl');

    echo "Informações do Servidor SOAP: ";
    print_r($client->getOptions());
    echo "Funções:";
    print_r($client->getFunctions());
    echo "Tipos:";
    print_r($client->getTypes());
    echo "Resultado:";
    print_r($client->obterSaldoAtualizado([
        'parcelas' => [
            'parcela' => [
                'data'  => '1994-06-18',
                'tipo'  => 'D',
                'valor' => '35.00'
            ]
        ],
        'aplicaJuros' => true,
        'dataAtualizacao' => '2019-12-04'
    ]));
});

/**
 * SOAP SERVER
 */

// Definição da descrição do WSDL - URL foi definida no vhost do apache
$uri = 'http://local.webservicephp';

$router->get('server-soap.wsdl', function () use ($uri) {
    $autoDiscover = new AutoDiscover();
    $autoDiscover->setUri("$uri/server");
    $autoDiscover->setServiceName('SERVERSOAP');
    $autoDiscover->addFunction('soma');
    $autoDiscover->handle();
});


$router->post('server', function() use ($uri) {
    $server = new Server("$uri/server-soap.wsdl", [
        'cache_wsdl' => WSDL_CACHE_NONE
    ]);

    $server->setUri("$uri/server");
    return $server
        -> setReturnResponse(true)
        ->addFunction("soma")
        ->handle(); //ira executar o envelope XML recebido
});

/**
 * Métodos da chamada RPC - SOAP SERVER
 */
/**
 * @param int $num1
 * @param int $num2
 * @return int
 */
function soma($num1, $num2)
{
    return $num1 + $num2;
}


/**
 * SOAP CLIENT
 */

$router->get('soap-teste', function() use ($uri) {
    //faz uma requisição GET para obter o WSDL que foi definido acima
    //o autodiscovery sera executado e ira retornar o wsdl e disponibilizar o método RPC SOMA
    $client = new Client("$uri/server-soap.wsdl", [
        'cache_wsdl' => WSDL_CACHE_NONE
    ]);

    print_r($client->soma(2,5));


});




