<?php
$router->get('/product', 'product@index');
// $router->get('/product', 'product@createProd');
$router->get('/', function () {
 echo 'hola mundo';
});
