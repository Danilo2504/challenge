<?php
$router->get('/products', 'product@index');
$router->get('/checkouts', 'checkout@index');
$router->post('/product', 'product@createProd');
$router->post('/webhook', 'stripe@webhook');
$router->post('/checkout', 'stripe@checkout');
