<?php
$routes = [
    'requestDelivery',
    'getDelivery',
    'cancelDelivery',
    'getDeliveries',
    'getQuote',
    'getAccessToken',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

