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
}