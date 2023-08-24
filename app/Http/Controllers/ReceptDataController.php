<?php

namespace App\Http\Controllers;

use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReceptDataController extends Controller
{
  public function getInitialToken(Request $request)
  {
    $payload = [
      'grant_type' => 'client_credentials',
      'scope' => 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes',
      'client_id' => $request['secret_id'],
      'client_secret' => $request['secret_key']
    ];
    $response = Http::asForm()->post('https://api-seguridad.sunat.gob.pe/v1/clientesextranet/' . $request['secret_id'] . '/oauth2/token', $payload);

    $data = $response->json();
    return $data;
  }

  public function getPedidos(Request $request)
  {
    $items = [
      [
        "userId" => 1,
        "id" => 1,
        "title" => "1/4 de Pollo a la Brasa",
        "body" => "Sumérgete en una experiencia culinaria auténticamente peruana con nuestro exquisito Pollo a la Brasa. Cuidadosamente marinado en una mezcla secreta de especias y hierbas tradicionales, nuestro pollo es asado a la perfección en brasas ardientes, logrando una piel dorada y crujiente que contrasta con la jugosa y tierna carne en su interior.",
        "image" => "https://elcomercio.pe/resizer/ACia80G2I9HVf4q4t8ms52V799c=/580x330/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/QLFEJCGWOREPLBYFE7H2FOPXFY.jpg",
        "price"=> "30.00",
        "cremas"=> ["Mayonesa", "Ketchup","Mostaza"]
      ],
      [
        "userId" => 1,
        "id" => 2,
        "title" => "1/2 Pollo a la Brasa",
        "body" => "This is the body of Item 2",
        "image" => "https://elcomercio.pe/resizer/ACia80G2I9HVf4q4t8ms52V799c=/580x330/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/QLFEJCGWOREPLBYFE7H2FOPXFY.jpg",
        "price"=> "30.00",
        "cremas"=> ["Mayonesa", "Ketchup","Aji"]
      ],
      [
        "userId" => 2,
        "id" => 3,
        "title" => "1 Pollo a la Brasa",
        "body" => "Te amo mi vida",
        "image" => "https://elcomercio.pe/resizer/ACia80G2I9HVf4q4t8ms52V799c=/580x330/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/QLFEJCGWOREPLBYFE7H2FOPXFY.jpg",
        "price"=> "30.00",
        "cremas"=> ["Mayonesa", "Ketchup","Mostaza","Aji"]
      ],
      [
        "userId" => 4,
        "id" => 3,
        "title" => "1/8 de Pollo a la Brasa",
        "body" => "This is the body of Item 3",
        "image" => "https://elcomercio.pe/resizer/ACia80G2I9HVf4q4t8ms52V799c=/580x330/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/QLFEJCGWOREPLBYFE7H2FOPXFY.jpg",
        "price"=> "30.00",
        "cremas"=> ["Ketchup","Mostaza","Aji"]
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
