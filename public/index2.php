<?php

use Slim\Factory\AppFactory;
// cargamos las clases
require __DIR__ . '/../vendor/autoload.php';
// declaramos
$app = AppFactory::create();
// ruta desde el servidor
$app->setBasePath("/UD5CARLOS/ejercicio14/public");
// añadir el middlewear
$app -> addBodyParsingMiddleware();
$app -> addRoutingMiddleware();
$app -> addErrorMiddleware(true,true,true);
// rutas
require 'facturas.php'; // rutas de las facturas
require 'productos.php'; // rutas de las productos
// ejecucion
$app->run();
?>