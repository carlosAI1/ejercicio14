<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//cargamos las clases
include (__DIR__ . '/include/conexion.php');
include (__DIR__ . '/../src/ProductosAPI.php');
require __DIR__ . '/../vendor/autoload.php';
// declaramos las clases
$lib = new db_lib();
$app = AppFactory::create();

// empezar la ruta desde el servidor
$app->setBasePath('/UD5CARLOS/ejercicio14/public');

//Añadimos el middleware para routing y errores
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true,true,true);
// ponemos en global en $productosAPI y declaramos con el parametro $con
global $productosAPI;

$productosAPI = new ProductosAPI($con);


$app->get('/',function( Request $request, Response $response){
    $response->getBody()->write("index de la clase ProductosAPI ve a /api/productos/");
    return $response;
});
// funcion de un solo producto de la clase ProductosAPI
$app->get('/api/productos/{id}',function( Request $request, Response $response, array $args){
    $id = $args['id'];
    global $productosAPI;
    $productosAPI->getProducto($id);
    return $response->withHeader('Content-Type', 'application/json');
    $accept= $request->getHeaders()['Accept'][0];
});
$app->get('/api/productos','obtenerProductos');
$app->get('/api/mediaProductos','mediaProductos');
$app->get('/api/buscarProductos/{nombre}','buscarProductos');
$app->post('/api/productos','crearProductos');
$app->put('/api/productos/actualizar/{id}', 'actualizarProducto');
$app->delete('/api/productos/eliminar/{id}','eliminarProducto');
//ejecucion
$app->run();
// funcion todos los productos de la clase ProductosAPI
function obtenerProductos(Request $request, Response $response){
    global $productosAPI;
    //$request->getHeaders()['Accept'];
    //print_r('los productos de la clase ProductosAPI: <br/>');
    $response->getBody()->write($productosAPI->getProductos());
    //echo '<br/>';
    return $response->withHeader('Content-Type', 'application/json');
}
//funcion para obtener la media de la clase ProductosAPI
function mediaProductos(Request $request, Response $response){
    global $productosAPI;
    $response->getBody()->write($productosAPI->mediaProductos());
    return $response->withHeader('Content-Type','application/json');
    $accept = $request->getHeaders()['Accept'][0];
}
// funcion busqueda de la clase ProductosAPI
function buscarProductos(Request $request,Response $response,array $args){
    global $productosAPI;
    $producto = $args['nombre'];
    if ($producto.ob_get_length() >= 3){
        $response->getBody()->write($productosAPI->buscarProductos($producto));
    }else{
        $response->getBody()->write(json_encode('Message: PRODUCT NOT FOUND'));
    }
    return $response->withHeader('Content-Type','application/json');
    $accept = $request->getHeaders()['Accept'][0];
}
//funcion para crear producto
function crearProductos(Request $request, Response $response){
    global $productosAPI;
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $productosAPI->crearProducto($nombre,$precio);

    $response->getBody()->write(json_encode('"INFO": "Producto creado"'));
    return $response->withHeader('Content-Type','application/json');

}

//funcion para actualizar producto
function actualizarProducto(Request $request, Response $response, array $args){
    global $productosAPI;
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $id = $args['id'];
    $response->getBody()->write($productosAPI->putProducto($id,$nombre,$precio));
    return $response->withHeader('Content-Type','application/json');
}
// funcion para eliminar producto
function eliminarProducto(Request $request, Response $response, array $args){
    global $productosAPI;
    $id = $args['id'];
    $response->getBody()->write($productosAPI->deleteProducto($id));
    return $response->withHeader('Content-Type','application/json');
}
$lib->closeCon($con);
?>