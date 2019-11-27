<?php

namespace App\Http;

use Illuminate\Contracts\Support\Arrayable;
use Laravel\Lumen\Http\ResponseFactory as Response;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;

/**
 * ResponseFactory: Classe responsável por formatar o response para json ou xml
 * caso o header contenha o accept application/json ou application/xml
 */
class ResponseFactory extends Response
{

    /**
     * make: Método responsável por criar a resposta, recebe como parametro
     * os mesmos implementados na ResponseFactory do Lumen e com isso de acordo
     * com o accept escolhido formata a resposta utilizando o response()->json() do lumen
     * ou utiliza o método getXML (que usa uma lib do zendframework config para ler e escrever)
     * em XML
     * @param array $headers (headers da requisição)
     * @param $content (conteudo da requisição)
     * @param $status (status da requisição)
     * @return $result ou $this->json
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        //Acessa o container de serviço do lumen e obtem a request
        /** @var Request $request */
        $request = app('request');
        $acceptHeader = $request->header('accept');

        if ($acceptHeader == '*/*') {
            //mesma coisa de utilizar response()->json()
            return $this->json($content, $status, $headers);
        }

        $result = null;
        switch ($acceptHeader) {
            case 'application/json':
                $result = $this->json($content, $status, $headers);
                break;
            case 'application/xml':
                //invoca o método da classe pai e passa os status e headers e o getXml gera
                //o response em xml
                $result = parent::make($this->getXml($content), $status, $headers);
                break;
        }

        return $result;


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
