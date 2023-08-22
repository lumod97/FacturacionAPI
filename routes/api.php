<?php
use Illuminate\Support\Facades\Route;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST,GET,PUT,PATCH,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

Route::group(
    ['prefix' => 'settings'],
    function () {
        Route::post('get-initial-token', 'App\Http\Controllers\ReceptDataController@getInitialToken');
        Route::post('generate-xml-document', 'App\Http\Controllers\GenerateXMLController@generateXml');
    }
);

Route::group(
    ['prefix' => 'pedidos'],
    function () {
        Route::post('get-carta', 'App\Http\Controllers\ReceptDataController@getPedidos');
    }
);