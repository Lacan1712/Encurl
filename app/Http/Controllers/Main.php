<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\shortlink;
class Main extends Controller
{
    /**
     * Armazena no banco o link original e encurtado, com verificação de duplicidade
     */
    public function store($origin_url, $shortLink, $perma_link)
    {
        //Model
        $table_shortLink = new shortlink();
        //Gerar ID único para a tabela
        $randomString = md5(uniqid());
        $numericOnly = preg_replace('/[^0-9]/', '', $randomString);
        $threeDigits = substr($numericOnly, 0, 3);


        $consulta = $this->show((string)$origin_url);

        if($consulta === null){
            //Função para armazenar o link original e o link encurtado
            //DB::insert('INSERT INTO shortlink VALUES (:ID, :ORIGIN_URL, :SHORT_URL)', $dados);
            $table_shortLink -> id = $threeDigits;
            $table_shortLink -> long_url = $origin_url;
            $table_shortLink -> short_url = $shortLink;
            $table_shortLink -> perma_link = $perma_link;
            $table_shortLink -> save();


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
            "CONSULTA" => $consulta
        ];

        // Verifica a duplicidade
        //DB::select("SELECT long_url FROM shortlink WHERE long_url = :CONSULTA", $dados);
        $resultado = shortlink::where('long_url',$consulta)->first();
        if (!empty($resultado->long_url)) {
             return $resultado->long_url;
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
            'CONSULTA' => 'SB'.$consulta
        ];

        $resultado = DB::select("SELECT long_url FROM shortlink WHERE short_url = :CONSULTA", $dados);

        if (!empty($resultado)) {
            return $resultado[0]->long_url;
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

        //Validação para o campo URL
        $validation = $request->validate([
            "origin-url" => 'required',
            "perma-link" => 'nullable'
        ]);

        //Armazena a url original
        $origin_url = $request->input('origin-url');

        //Armazena o link encurtado
        $shortLink = $this->hashUrl($origin_url);

        //Aramazena checkbox de link permanente
        $perma_link = $request->has('perma-link');

        //Função de insert na tabela com lik permanente
        if($this->store(trim($origin_url), trim($shortLink), $perma_link) === 0){
            return view('home_page',['mensagem' => 'Este link já foi encurtado','endereco' => 'localhost:8000/'.$shortLink]);
        }else{
            return view('home_page',['mensagem' => 'Link encurtado com sucesso:','endereco' => 'localhost:8000/'.$shortLink]);
        }


        return redirect()->route('home');

    }

    //Função de redirecionamento da URL encurtada
    public function redirectURL($ID){

        $long_url = $this->showOriginUrl($ID);
        header("Location: $long_url");
        exit();

    }


}
