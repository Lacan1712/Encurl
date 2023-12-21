<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;
use App\Models\shortlink;


class Main extends Controller
{
    /**
     * Armazene o link encurtado.
     */
    public function store($origin_url, $shortLink)
    {
        /* Gerar ID único para a tabela

            $randomString = md5(uniqid());
            $numericOnly = preg_replace('/[^0-9]/', '', $randomString);
            $threeDigits = substr($numericOnly, 0, 3);

        */

        //Obtaendo timezone do servidor
        $timezone_servidor = date_default_timezone_get();

        //Cria o objeto de data
        $hora_local_servidor = new DateTime('now', new DateTimeZone($timezone_servidor));



        //Guardando em arrays as URL's
        $dados = [
            //'ID' => $threeDigits,
            'long_url' => $origin_url,
            'short_url' => $shortLink,
            'created_at' => (string)$hora_local_servidor->format('Y-m-d H:i:s'),
        ];

        $consulta = $this->show((string)$origin_url);

        if($consulta === null){
            //Função para armazenar o link original e o link encurtado
            DB::insert('INSERT INTO shortlink(long_url,short_url,created_at) VALUES (:long_url, :short_url, :created_at)', $dados);

        }else{
            return 0;
        }

    }

    /**
     * Consulta URL encurtada.
     */
    public function show($consulta)
    {
        $dados = [
            "long_url" => $consulta
        ];

        // Verifica a duplicidade
        $resultado = shortlink::where($dados)->first(); //("SELECT long_url FROM shortlink WHERE long_url = :CONSULTA", $dados);
        if (!empty($resultado)) {
            return $resultado->short_url;
        } else {
            return null;
        }
    }
    /**
     * Consulta URL ORIGINAL.
     */

    public function showOriginUrl($consulta)
    {
        $dados = [
            'short_url' => 'SB'.$consulta
        ];
        
        $resultado = shortlink::where($dados)->first(); //("SELECT long_url FROM shortlink WHERE short_url = :CONSULTA", $dados);

        if (!empty($resultado)) {
            return $resultado->long_url;
        } else {
            return null;
        }

    }


    public function hashUrl($origin_url){
        //Prefixo da rota
        $Prefix = 'SB';

        //Identificado único
        $uniqueIdentifier = substr(md5(uniqid()), 0, 5);

        //retorno com prefixo e ID
        return $Prefix . $uniqueIdentifier;


    }

    //Função de retorno da URL encurtada
    public function encurl(Request $request){
        //Armazena a url original
        $origin_url = $request->input('origin-url');

        //Cria o ID do link encurtado
        $shortLink = $this->hashUrl($origin_url);

        //Validação para o campo URL
        $validation = $request->validate([
                "origin-url" => 'required'
            ]);

        

        //Função de insert na tabela
        if($this->store($origin_url, $shortLink) === 0){
            return view('home_page',['mensagem' => 'ESSE LINK JÁ ESTÁ ENCURTADO: https://cut.rr.sebrae.com.br/'.$shortLink]);
        }else{
            return view('home_page',['mensagem' => 'https://cut.rr.sebrae.com.br/'.$shortLink]);
        }

        return redirect()->route('home');
    }

    //Função de redirecionamento da URL encurtada
    public function redirectURL($ID){

        (string)$long_url = $this->showOriginUrl($ID);
        header("Location: $long_url");
        exit();

    }


}
