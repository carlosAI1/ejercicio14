<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
// inicializamos las clases
require __DIR__ . '/../vendor/autoload.php';
include (__DIR__.'/include/conexion.php');
include (__DIR__.'/../src/FacturaAPI.php');

$lib = new db_lib();

$app = AppFactory::create();
// ruta servidor
$app->setBasePath("/UD5CARLOS/ejercicio14/public");

// middleware
$app -> addBodyParsingMiddleware();
$app -> addRoutingMiddleware();
$app -> addErrorMiddleware(true,true,true);

global $facturaAPI;
$facturaAPI = new FacturaAPI($con);

$app->get('/',function( Request $request, Response $response){
    $response->getBody()->write("index de la clase FacturasAPI ve a /api/facturas/");
    return $response;
});
// funcion de un solo producto de la clase facturaAPI
$app->get('/api/facturas/{id}',function( Request $request, Response $response, array $args){
    $id = $args['id'];
    global $facturaAPI;
    $facturaAPI->getFactura($id);
    return $response->withHeader('Content-Type', 'application/json');
    $accept= $request->getHeaders()['Accept'][0];
});
$app->get('/api/facturas', 'obtenerFacturas');
$app->post('/api/facturas', 'crearFactura');
$app->delete('/api/facturas/eliminar/{id}','eliminarFactura');
$app->run();

function obtenerFacturas(Request $request, Response $response){
    global $facturaAPI;
    $response->getBody()->write($facturaAPI->getFacturas());
    return $response->withHeader('Content-Type', 'application/json');
}
function crearFactura(Request $request, Response $response){
    global $facturaAPI;
    $cliente = $_POST['cliente'];
    $monto = $_POST['monto'];
    $response->getBody()->write($facturaAPI->postFacturas($cliente, $monto));
    return $response->withHeader('Content-Type', 'application/json');
}
function eliminarFactura (Request $request, Response $response, array $params){
    global $facturaAPI;
    $id = $params['id'];
    $response->getBody->write($facturaAPI->deleteFactura($id));
    return $response->withHeader('Content-Type', 'application/json');
}
$lib->closeCon($con);

?>