<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReceptDataController extends Controller
{
    public function getInitialToken(Request $request)
    {
        $payload = [
            'grant_type'=>'client_credentials',
            'scope'=>'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes',
            'client_id'=>$request['secret_id'],
            'client_secret'=>$request['secret_key']
        ];
        $response = Http::asForm()->post('https://api-seguridad.sunat.gob.pe/v1/clientesextranet/'.$request['secret_id'].'/oauth2/token', $payload);

        $data = $response->json();
        return $data;
    }

    public function getPedidos(Request $request)
    {   
        $items = [
            [
              "userId" => 1,
              "id" => 1,
              "title" => "Item 1",
              "body" => "This is the body of Item 1"
            ],
            [
              "userId" => 1,
              "id" => 2,
              "title" => "Item 2",
              "body" => "This is the body of Item 2"
            ],
            [
              "userId" => 2,
              "id" => 3,
              "title" => "Item 3",
              "body" => "This is the body of Item 3"
            ],
            [
                "userId" => 4,
                "id" => 3,
                "title" => "Item 3",
                "body" => "This is the body of Item 3"
              ]
          ];
          
          // Crear una respuesta JSON
          $response = [
            "success" => true,
            "message" => "Data retrieved successfully",
            "data" => $items
          ];
          
          // Configurar las cabeceras para indicar que la respuesta es JSON
          header("Content-Type: application/json");
          
          // Enviar la respuesta JSON
          return json_encode($response);
    }
}