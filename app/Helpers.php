<?php

use App\Http\ResponseFactory;

/**
 * responseHelper: Helper responsável por criar a resposta
 * o mesmo utiliza o ResponseFactory para gerar as respostas
 * de acordo com o Accept pedido.
 * Recebe os mesmos parametros do response()->json(), na mesma ordem
 * @param $content (conteúdo da resposta)
 * @param $status (Status code da resposta)
 * @param $headers (headers)
 * @return ResponseFactory $factory
 *
 * Formas de utilização
 * return responseHelper()->make()
 * ou return responseHelper($headers, $content, $status)
 * OBS: arquivo incluido no autoload do composer.json
 */
function responseHelper($content = '', $status = 200, array $headers = []) {

    $factory = new ResponseFactory();

    //conta o numero de argumentos passados para a função e caso seja 0 retornara
    // a instancia da classe
    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->make($content, $status, $headers);
}
